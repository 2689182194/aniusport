<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo`.
 */
class m170531_090320_create_seo_table extends Migration
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
        $this->createTable('{{%seo_meta}}', [
            'id' => $this->primaryKey(),
            'entity' => $this->integer(11)->notNull()->defaultValue(0)->comment('数据ID'),
            'model'=>$this->string(255)->notNull()->defaultValue('')->comment('数据模型类'),
            'route'=>$this->string(255)->notNull()->defaultValue('')->comment('路由'),
            'title'=>$this->string(255)->notNull()->defaultValue('')->comment('标题'),
            'keywords'=>$this->text()->comment('关键字'),
            'description'=>$this->text()->comment('描述'),
            'robots'=>$this->string(100)->notNull()->defaultValue('')->comment('蜘蛛授权'),
        ], $tableOptions);
        // creates index for column `tag_id`
        $this->createIndex(
            'entity_model_route',
            '{{%seo_meta}}',
            'entity,model,route',
            'true'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'entity_model_route',
            '{{%seo_meta}}'
        );
        $this->dropTable('{{%seo_meta}}');
    }
}
