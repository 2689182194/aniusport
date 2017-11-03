<?php

namespace grazio\gos\models;

use Yii;

/**
 * This is the model class for table "media_item".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $file_extension
 * @property integer $file_version
 * @property string $file_size
 * @property string $hash
 * @property string $file_name
 * @property string $source_owner
 * @property string $source_form
 * @property string $source_attribute
 * @property integer $source_id
 */
class GosItemModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gos_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['file_version','source_id'], 'integer'],
            [['name','file_name'], 'string', 'max' => 255],
            [['hash'], 'string', 'max' => 64],
            [['file_extension'], 'string', 'max' => 10],
            [['file_size','source_owner','source_form','source_attribute'], 'string', 'max' => 100],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'fileExtension' => 'File Extension',
            'fileVersion' => 'File Version',
        ];
    }

}
