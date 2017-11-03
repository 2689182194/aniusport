<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m170427_075418_create_image_table extends Migration
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
        $this->createTable('{{%news_image}}', [
            'image_id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull()->defaultValue(0)->comment('新闻id'),
            'image_url' => $this->string(255)->notNull()->defaultValue('')->comment('新闻图片地址'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%news_image}}');
    }
}
