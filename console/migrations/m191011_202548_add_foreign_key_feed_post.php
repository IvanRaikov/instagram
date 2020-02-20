<?php

use yii\db\Migration;

/**
 * Class m191011_202548_add_foreign_key_feed_post
 */
class m191011_202548_add_foreign_key_feed_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('feed_post_fk', 'feed', 'post_id', 'post', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('feed_post_fk', 'feed');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191011_202548_add_foreign_key_feed_post cannot be reverted.\n";

        return false;
    }
    */
}
