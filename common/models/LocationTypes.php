<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "location_types".
 *
 * @property int $location_type_id Unique identifier for the location type
 * @property string $type_name Name of the location type
 *
 * @property Properties[] $properties
 */
class LocationTypes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'location_types';
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
            'location_type_id' => 'Location Type ID',
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
        return $this->hasMany(Properties::class, ['location_type_id' => 'location_type_id']);
    }

}
