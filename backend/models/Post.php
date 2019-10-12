<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_name
 * @property string $description
 * @property int $created_at
 * @property int $complaints
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
            'complaints' => 'Complaints',
        ];
    }
    public static function findComplaints(){
        return SELF::find()->where('complaints > 0')->orderBy('complaints desc');
    }
    public function approve(){
        $redis = Yii::$app->redis;
        $redis->del("post:{$this->id}:complaints");
        $this->complaints = 0;
        return $this->save(false, ['complaints']);
    }
}
