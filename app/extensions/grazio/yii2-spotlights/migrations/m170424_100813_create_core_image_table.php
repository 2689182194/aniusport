<?php

use yii\db\Migration;

/**
 * Handles the creation of table `core_image`.
 */
class m170424_100813_create_core_image_table extends Migration
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
        $this->createTable('{{%core_image}}', [
            'image_id' => $this->primaryKey()->unsigned(),
            'local_path' => $this->string(255)->notNull()->defaultValue('')->comment('本地路径'),
            'upload_code' => $this->integer(4)->notNull()->defaultValue(0)->comment('上传返回值'),
            'url' => $this->string(255)->notNull()->defaultValue('')->comment('URL'),
            'file' => $this->string(200)->notNull()->defaultValue('')->comment('文件'),
            'link' => $this->string(200)->notNull()->defaultValue('')->comment('链接地址'),
            'type' => 'enum("EXTERNAL", "INTERNAL") NOT NULL DEFAULT "INTERNAL" COMMENT "站内／站外"',
            'status' => 'enum("DRAFT", "POSTED","DELETED","OFFLINE") NOT NULL DEFAULT "POSTED" COMMENT "状态"',
            'image_source_type' => $this->string(255)->notNull()->defaultValue('')->comment('图片来源类型'),
            'image_source_id' => $this->integer()->notNull()->defaultValue(0)->comment('图片来源ID'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%core_image}}');
    }
}
