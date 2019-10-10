<?php

use yii\db\Migration;

/**
 * Class m191006_065957_create_table_post
 */
class m191006_065957_create_table_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post',[
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'file_name'=>$this->string()->notNull(),
            'description'=>$this->text(),
            'created_at'=>$this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191006_065957_create_table_post cannot be reverted.\n";

        return false;
    }
    */
}
