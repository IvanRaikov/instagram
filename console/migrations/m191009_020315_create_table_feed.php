<?php

use yii\db\Migration;

/**
 * Class m191009_020315_create_table_feed
 */
class m191009_020315_create_table_feed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('feed',[
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer(),
            'autor_id'=>$this->integer(),
            'autor_name'=>$this->string(),
            'autor_nickname'=>$this->string(),
            'autor_picture'=>$this->string(),
            'post_id'=>$this->integer(),
            'post_filename'=>$this->string()->notNull(),
            'post_description'=>$this->text(),
            'post_created_at'=>$this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('feed');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191009_020315_create_table_feed cannot be reverted.\n";

        return false;
    }
    */
}
