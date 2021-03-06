<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use frontend\models\Feed;
use frontend\models\Post;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $about
 * @property integer $type
 * @property string $nickname
 * @property string $picture
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const DEFAULT_IMAGE = 'no-image.jpg';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * 
     * @return mixed
     */
    public function getNickname(){
        return $this->nickname ? $this->nickname : $this->id;
    }
    public function fallowUser(User $user){
        $redis = Yii::$app->redis;
        $redis->sadd("user:{$this->id}:subscriptions", $user->id);
        $redis->sadd("user:{$user->id}:followers", $this->id);
    }
    public function unfallowUser(User $user){
        $redis = Yii::$app->redis;
        $redis->srem("user:{$this->id}:subscriptions", $user->id);
        $redis->srem("user:{$user->id}:followers", $this->id);
    }
    public function getSubscriptions(){
        $redis = Yii::$app->redis;
        $ids = $redis->smembers("user:{$this->id}:subscriptions");
        return SELF::find()->select('id,username,nickname,picture')->where(['id'=>$ids])->orderBy('username')->all();
    }
    public function getFollowers(){
        $redis = Yii::$app->redis;
        $ids = $redis->smembers("user:{$this->id}:followers");
        return SELF::find()->select('id,username,nickname,picture')->where(['id'=>$ids])->orderBy('username')->all();
    }
    public function countSubscriptions(){
        $redis = Yii::$app->redis;
        return $redis->scard("user:$this->id:subscriptions");
    }
    public function countFollowers(){
        $redis = Yii::$app->redis;
        return $redis->scard("user:$this->id:followers");
    }
    public function getCommonFriends($user){
        $redis = Yii::$app->redis;
        $key1 = "user:$this->id:subscriptions";
        $key2 = "user:$user->id:followers";
        $ids = $redis->sinter($key1, $key2);
        return SELF::find()->where(['id'=>$ids])->orderBy('username')->all();
    }
    public function getPicture(){
        if($this->picture){
            return Yii::$app->storage->getFile($this->picture);
        }return '/uploads/'.SELF::DEFAULT_IMAGE;
    }
    public function getFeed($limit, $offset = null){
        if($offset == null){
           return $this->hasMany(Feed::className(), ['user_id'=>'id'])->orderBy(['post_created_at'=>SORT_DESC])->limit($limit)->all(); 
        }
        return $this->hasMany(Feed::className(), ['user_id'=>'id'])->orderBy(['post_created_at'=>SORT_DESC])->offset($offset)->limit($limit)->all();
    }
    public function getMoreFeed($limit, $offset){
        $response = [];
        $feeds = $this->getFeed($limit, $offset);
        $i =0;
        foreach($feeds as $feed){
            $post = Post::findOne($feed->post_id);
            $response[$i]['autor_id']=$feed->autor_id;
            $response[$i]['autor_name']=$feed->autor_name;
            $response[$i]['autor_picture']=$feed->autor_picture;
            $response[$i]['post_id']=$feed->post_id;
            $response[$i]['created_at']=Yii::$app->formatter->asDatetime($feed->post_created_at);
            $response[$i]['post_description']=$feed->post_description;
            $response[$i]['post_filename']=$feed->post_filename;
            $response[$i]['is_liked']=$this->isLikedBy($feed->post_id);
            $response[$i]['is_reported']=$post->isReported($this);
            $response[$i]['count_likes']=$post->countLikes();
            $i++;
        }
        return $response;
    }
    public function isLikedBy($postId){
        $redis = Yii::$app->redis;
        return $redis->sismember("user:{$this->id}:likes",$postId);
    }
    public function getPost(){
        return $this->hasMany(Post::className(), ['user_id'=>'id']);
    }
}
