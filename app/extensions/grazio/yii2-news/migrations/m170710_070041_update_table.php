<?php

use yii\db\Migration;

class m170710_070041_update_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news_content}}', 'updated_at', $this->integer()->notNull()->defaultValue(0)->comment('修改时间'));
        $this->addColumn('{{%news_content}}', 'created_by', $this->integer()->notNull()->defaultValue(0)->comment('创建人'));
        $this->addColumn('{{%news_content}}', 'updated_by', $this->integer()->notNull()->defaultValue(0)->comment('修改人'));
        $this->addColumn('{{%news_content}}', 'deleted_by', $this->integer()->notNull()->defaultValue(0)->comment('删除人'));

        $this->addColumn('{{%news_image}}', 'updated_at', $this->integer()->notNull()->defaultValue(0)->comment('修改时间'));
        $this->addColumn('{{%news_image}}', 'created_by', $this->integer()->notNull()->defaultValue(0)->comment('创建人'));
        $this->addColumn('{{%news_image}}', 'updated_by', $this->integer()->notNull()->defaultValue(0)->comment('修改人'));
        $this->addColumn('{{%news_image}}', 'deleted_by', $this->integer()->notNull()->defaultValue(0)->comment('删除人'));
        $this->addColumn('{{%news_image}}', 'deleted_at', $this->integer()->notNull()->defaultValue(0)->comment('删除时间'));

    }

    public function down()
    {
        $this->dropColumn('{{%news_image}}', 'deleted_at');
        $this->dropColumn('{{%news_image}}', 'deleted_by');
        $this->dropColumn('{{%news_image}}', 'updated_by');
        $this->dropColumn('{{%news_image}}', 'created_by');
        $this->dropColumn('{{%news_image}}', 'updated_at');

        $this->dropColumn('{{%news_content}}', 'deleted_by');
        $this->dropColumn('{{%news_content}}', 'updated_by');
        $this->dropColumn('{{%news_content}}', 'created_by');
        $this->dropColumn('{{%news_content}}', 'updated_at');
    }

}
