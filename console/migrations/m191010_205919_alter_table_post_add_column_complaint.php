<?php

use yii\db\Migration;

/**
 * Class m191010_205919_alter_table_post_add_column_complaint
 */
class m191010_205919_alter_table_post_add_column_complaint extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'complaints', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post', 'complaints');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_205919_alter_table_post_add_column_complaint cannot be reverted.\n";

        return false;
    }
    */
}
