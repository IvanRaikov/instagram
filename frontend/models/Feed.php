<?php

namespace frontend\models;

use Yii;
use frontend\models\User;

/**
 * This is the model class for table "feed".
 *
 * @property int $id
 * @property int $user_id
 * @property int $autor_id
 * @property string $autor_name
 * @property int $autor_nickname
 * @property string $autor_picture
 * @property int $post_id
 * @property string $post_filename
 * @property string $post_description
 * @property int $post_created_at
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feed';
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'autor_id' => 'Autor ID',
            'autor_name' => 'Autor Name',
            'autor_nickname' => 'Autor Nickname',
            'autor_picture' => 'Autor Picture',
            'post_id' => 'Post ID',
            'post_filename' => 'Post Filename',
            'post_description' => 'Post Description',
            'post_created_at' => 'Post Created At',
        ];
    }
    public function countLikes()
    {
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->post_id}:likes");
    }
    public function isReported(User $currentUser)
    {
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->post_id}:complaints", $currentUser->id);
    }
}
