<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m170427_072340_create_news_table extends Migration
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
        $this->createTable('{{%news}}', [
            'news_id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull()->defaultValue(0)->comment('新闻分类id'),
            'title' => $this->string(100)->notNull()->defaultValue('')->comment('新闻标题'),
            'subtitle' => $this->string(255)->notNull()->defaultValue('')->comment('新闻副标题'),
            'summary'=>$this->text()->comment('新闻摘要'),
            'keywords'=>$this->string(100)->notNull()->defaultValue('')->comment('新闻关键字'),
            'author'=>$this->string(100)->notNull()->defaultValue('')->comment('新闻作者'),
            'artist'=>$this->text()->comment('新闻相关艺术家'),
            'source'=>$this->string(255)->notNull()->defaultValue('')->comment('新闻来源'),
            'label'=>$this->string(255)->notNull()->defaultValue('')->comment('新闻标签'),
            'source_link'=>$this->string(255)->notNull()->defaultValue('')->comment('新闻原文链接'),
            'status' => 'enum("DRAFT", "PUBLISHED") NOT NULL DEFAULT "PUBLISHED" COMMENT "状态 PUBLISHED--发布状态,DRAFT--草稿状态"',
            'type' => 'enum("TEXT", "GALLERY","VIDEO") NOT NULL DEFAULT "TEXT" COMMENT "类型 TEXT--文本类型,GALLERY--画廊类型,VIDEO--视频类型"',
            'headline' => $this->smallInteger(2)->notNull()->defaultValue(0)->comment('是否是头条新闻 0-否 1-是'),
            'publish_id' => $this->integer()->notNull()->defaultValue(0)->comment('新闻发布者id'),
            'publish_time' => $this->integer()->notNull()->defaultValue(0)->comment('新闻发布时间'),
            'read_times' => $this->integer()->notNull()->defaultValue(0)->comment('新闻被阅读的次数'),
            'comment_times' => $this->integer()->notNull()->defaultValue(0)->comment('新闻被评论的次数'),
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
        $this->dropTable('{{%news}}');;
    }
}
