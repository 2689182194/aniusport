<?php

use yii\db\Migration;

class m170527_103329_add_image_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news_image}}', 'is_deleted', $this->smallInteger(2)->notNull()->defaultValue(0)->comment('是否删除 0-否 1-是'));
        $this->addColumn('{{%news_content}}', 'is_deleted', $this->smallInteger(2)->notNull()->defaultValue(0)->comment('是否删除 0-否 1-是'));
    }

    public function down()
    {
        $this->dropColumn('{{%news_content}}','is_deleted');
        $this->dropColumn('{{%news_image}}', 'is_deleted');
    }
}
