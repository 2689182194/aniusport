<?php

use yii\db\Migration;

/**
 * Handles the creation of table `spotlights_slice`.
 */
class m170424_093032_create_spotlights_slice_table extends Migration
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
        $this->createTable('{{%spotlights_slice}}', [
            'id' => $this->primaryKey()->unsigned(),
            'group_id' => $this->integer(11)->notNull()->comment('分组'),
            'title' => $this->string(200)->notNull()->defaultValue('')->comment('标题'),
            'description' => $this->string(200)->notNull()->defaultValue('')->comment('摘要'),
            'file' => $this->string(200)->notNull()->defaultValue('')->comment('文件'),
            'link' => $this->string(200)->notNull()->defaultValue('')->comment('链接地址'),
            'type' => 'enum("EXTERNAL", "INTERNAL") NOT NULL DEFAULT "INTERNAL" COMMENT "站内／站外"',
            'status' => 'enum("DRAFT", "POSTED","DELETED","OFFLINE") NOT NULL DEFAULT "POSTED" COMMENT "状态"',
            'weight' => $this->smallInteger(2)->notNull()->defaultValue(99)->comment('排序'),
            'begin_at' => $this->integer()->notNull()->defaultValue(0)->comment('开始时间'),
            'end_at' => $this->integer()->notNull()->defaultValue(0)->comment('结束时间'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'deleted_at' => $this->integer()->notNull()->defaultValue(0)->comment('删除时间'),
        ], $tableOptions);


    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropTable('{{%spotlights_slice}}');
    }
}
