<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sandbox`.
 */
class m170531_100113_create_sandbox_table extends Migration
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
        $this->createTable('{{%sandbox}}', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(255)->notNull()->defaultValue(''),
            'attachment'=>$this->string(255)->notNull()->defaultValue(''),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%sandbox}}');
    }
}
