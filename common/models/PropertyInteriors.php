<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_interiors".
 *
 * @property int $property_interior_id ID định danh cho mỗi liên kết property-interior
 * @property int $property_id Khóa ngoại đến bảng properties
 * @property int $interior_id Khóa ngoại đến bảng interiors
 *
 * @property Interiors $interior
 * @property Properties $property
 */
class PropertyInteriors extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_interiors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'interior_id'], 'required'],
            [['property_id', 'interior_id'], 'integer'],
            [['property_id', 'interior_id'], 'unique', 'targetAttribute' => ['property_id', 'interior_id']],
            [['interior_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interiors::class, 'targetAttribute' => ['interior_id' => 'interior_id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_interior_id' => 'Property Interior ID',
            'property_id' => 'Property ID',
            'interior_id' => 'Interior ID',
        ];
    }

    /**
     * Gets query for [[Interior]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterior()
    {
        return $this->hasOne(Interiors::class, ['interior_id' => 'interior_id']);
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
