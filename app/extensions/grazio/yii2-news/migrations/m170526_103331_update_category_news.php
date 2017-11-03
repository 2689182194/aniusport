<?php

use yii\db\Migration;

class m170526_103331_update_category_news extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news_category}}', 'created_by', $this->integer()->notNull()->defaultValue(0)->comment('创建人'));
        $this->renameColumn('{{%news_category}}','update_by', 'updated_by');
        $this->renameColumn('{{%news_category}}','update_at', 'updated_at');
    }

    public function down()
    {
        $this->renameColumn('{{%news_category}}','updated_at','update_at');
        $this->renameColumn('{{%news_category}}','updated_by','update_by');
        $this->dropColumn('{{%news_category}}', 'created_by');
    }
}
