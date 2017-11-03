<?php

use yii\db\Migration;

/**
 * Handles the creation of table `spotlights_group`.
 */
class m170424_083135_create_spotlights_group_table extends Migration
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
        $this->createTable('{{%spotlights_group}}', [
            'group_id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->defaultValue('')->comment('名称'),
            'description' => $this->string(250)->notNull()->defaultValue('')->comment('备注'),
            'status' => 'enum("DRAFT", "POSTED","DELETED","OFFLINE") NOT NULL DEFAULT "POSTED" COMMENT "状态"',
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'deleted_at' => $this->integer()->notNull()->defaultValue(0)->comment('删除时间'),
        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropTable('{{%spotlights_group}}');
    }
}
