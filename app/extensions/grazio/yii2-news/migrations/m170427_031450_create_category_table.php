<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m170427_031450_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%news_category}}', [
            'category_id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull()->defaultValue(0)->comment('父类id'),
            'category_name' => $this->string(50)->notNull()->defaultValue('')->comment('分类名称'),
            'category_desc' => $this->text()->comment('备注'),
            'status' => 'enum("DRAFT", "PUBLISHED") NOT NULL DEFAULT "PUBLISHED" COMMENT "状态 PUBLISHED--发布状态,DRAFT--草稿状态"',
            'sort' => $this->integer(5)->notNull()->defaultValue(99)->comment('排序'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_at' => $this->integer()->notNull()->defaultValue(0)->comment('修改时间'),
            'update_by'=>$this->integer(11)->notNull()->defaultValue(0)->comment('修改人'),
            'is_deleted'=>$this->smallInteger(2)->notNull()->defaultValue(0)->comment('是否删除 0-否 1-是'),
            'deleted_at'=>$this->integer(11)->notNull()->defaultValue(0)->comment('删除时间'),
            'deleted_by'=>$this->integer(11)->notNull()->defaultValue(0)->comment('删除人'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%news_category}}');
    }
}
