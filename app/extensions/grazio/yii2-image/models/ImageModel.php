<?php

namespace grazio\image\models;

use Yii;

/**
 * This is the model class for table "{{%sys_image}}".
 *
 * @property integer $image_id
 * @property string $local_path
 * @property integer $upload_code
 * @property string $url
 * @property string $image_source_type
 * @property integer $image_source_id
 */
class ImageModel extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%core_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_source_id'], 'integer'],
            [['image_source_type'], 'string'],
            [['local_path', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'local_path' => 'Local Path',
            'upload_code' => 'Upload Code',
            'url' => 'Url',
            'image_source_type' => 'Image Source Type',
            'image_source_id' => 'Image Source ID',
        ];
    }
}
