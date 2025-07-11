<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_images".
 *
 * @property int $id
 * @property int $property_id
 * @property string $file_name
 * @property string $file_path
 * @property string|null $type
 *
 * @property Properties $property
 */
class PropertyImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_images';
    }

    /**
     * {@inheritdoc}
     */
    
     public function rules()
     {
         return [
             [['property_id', 'file_name', 'file_path'], 'required', 'message' => '{attribute} không được để trống'],
             [['property_id'], 'integer', 'message' => 'ID bất động sản phải là số nguyên'],
             [['type'], 'string', 'max' => 50, 'tooLong' => 'Loại hình ảnh không được vượt quá 50 ký tự'],
             [['file_name', 'file_path'], 'string', 'max' => 255, 'tooLong' => '{attribute} không được vượt quá 255 ký tự'],
             [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id'], 'message' => 'Bất động sản không hợp lệ'],
         ];
     }
 
     public function attributeLabels()
     {
         return [
             'id' => 'ID Hình ảnh',
             'property_id' => 'ID Bất động sản',
             'file_name' => 'Tên file',
             'file_path' => 'Đường dẫn file',
             'type' => 'Loại hình ảnh',
         ];
     }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Properties::class, ['property_id' => 'property_id']);
    }

}
