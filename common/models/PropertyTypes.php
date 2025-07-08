<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_types".
 *
 * @property int $property_type_id Unique identifier for the property type
 * @property string $type_name Name of the property type
 *
 * @property Properties[] $properties
 */
class PropertyTypes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_name'], 'required'],
            [['type_name'], 'string', 'max' => 100],
            [['type_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_type_id' => 'Property Type ID',
            'type_name' => 'Type Name',
        ];
    }

    /**
     * Gets query for [[Properties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Properties::class, ['property_type_id' => 'property_type_id']);
    }

    

}
