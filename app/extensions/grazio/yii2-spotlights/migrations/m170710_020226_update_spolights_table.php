<?php

use yii\db\Migration;

class m170710_020226_update_spolights_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%spotlights_group}}', 'updated_at', $this->integer()->notNull()->defaultValue(0)->comment('修改时间'));
        $this->addColumn('{{%spotlights_group}}', 'created_by', $this->integer()->notNull()->defaultValue(0)->comment('创建人'));
        $this->addColumn('{{%spotlights_group}}', 'updated_by', $this->integer()->notNull()->defaultValue(0)->comment('修改人'));
        $this->addColumn('{{%spotlights_group}}', 'is_deleted', $this->smallInteger()->notNull()->defaultValue(0)->comment('是否删除，0-否，1-是'));
        $this->addColumn('{{%spotlights_group}}', 'deleted_by', $this->integer()->notNull()->defaultValue(0)->comment('删除人'));

        $this->addColumn('{{%spotlights_slice}}', 'flag', $this->smallInteger()->notNull()->defaultValue(0)->comment('是否显示，1-显示；0-隐藏'));
        $this->addColumn('{{%spotlights_slice}}', 'updated_at', $this->integer()->notNull()->defaultValue(0)->comment('修改时间'));
        $this->addColumn('{{%spotlights_slice}}', 'created_by', $this->integer()->notNull()->defaultValue(0)->comment('创建人'));
        $this->addColumn('{{%spotlights_slice}}', 'updated_by', $this->integer()->notNull()->defaultValue(0)->comment('修改人'));
        $this->addColumn('{{%spotlights_slice}}', 'is_deleted', $this->smallInteger()->notNull()->defaultValue(0)->comment('是否删除，0-否，1-是'));
        $this->addColumn('{{%spotlights_slice}}', 'deleted_by', $this->integer()->notNull()->defaultValue(0)->comment('删除人'));
    }

    public function down()
    {
        $this->dropColumn('{{%spotlights_group}}', 'deleted_by');
        $this->dropColumn('{{%spotlights_group}}', 'is_deleted');
        $this->dropColumn('{{%spotlights_group}}', 'updated_by');
        $this->dropColumn('{{%spotlights_group}}', 'created_by');
        $this->dropColumn('{{%spotlights_group}}', 'updated_at');

        $this->dropColumn('{{%spotlights_slice}}', 'deleted_by');
        $this->dropColumn('{{%spotlights_slice}}', 'is_deleted');
        $this->dropColumn('{{%spotlights_slice}}', 'updated_by');
        $this->dropColumn('{{%spotlights_slice}}', 'created_by');
        $this->dropColumn('{{%spotlights_slice}}', 'updated_at');
        $this->dropColumn('{{%spotlights_slice}}', 'flag');
    }

}
