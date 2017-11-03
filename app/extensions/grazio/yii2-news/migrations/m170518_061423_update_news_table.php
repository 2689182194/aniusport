<?php

use yii\db\Migration;

class m170518_061423_update_news_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news}}', 'created_by', $this->integer()->notNull()->defaultValue(0)->comment('创建人'));
        $this->renameColumn('{{%news}}','update_by', 'updated_by');
        $this->renameColumn('{{%news}}','update_at', 'updated_at');
    }

    public function down()
    {
        $this->renameColumn('{{%news}}','updated_at','update_at');
        $this->renameColumn('{{%news}}','updated_by','update_by');
        $this->dropColumn('{{%news}}', 'created_by');
    }
}
