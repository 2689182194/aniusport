<?php

use yii\db\Migration;

/**
 * Handles the creation of table `content`.
 */
class m170427_074619_create_content_table extends Migration
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
        $this->createTable('{{%news_content}}', [
            'content_id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull()->defaultValue(0)->comment(''),
            'content' => $this->Text()->comment('详细内容'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'deleted_at'=>$this->integer(11)->notNull()->defaultValue(0)->comment('是否删除 0-否 1-是'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%news_content}}');
    }
}
