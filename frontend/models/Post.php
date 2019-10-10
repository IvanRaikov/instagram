<?php

namespace app\models;

use frontend\models\User;
use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $description
 * @property int $created_at
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'file_name' => 'File Name',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id', 'user_id']);
    }
    public function like(User $currentUser){
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->id}:likes", $currentUser->id);
        $redis->sadd("user:{$currentUser->id}:likes", $this->id);
        return $this->countLikes();
    }
    public function countLikes(){
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->id}:likes");
    }
    public function dislike(User $currentUser){
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->id}:likes", $currentUser->id);
        $redis->srem("user:{$currentUser->id}:likes", $this->id);
        return $this->countLikes();
    }
    public function isLikedBy(User $currentUser){
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->id}:likes", $currentUser->id);
    }
}
