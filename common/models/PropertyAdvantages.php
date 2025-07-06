<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_advantages".
 *
 * @property int $property_advantage_id Unique identifier for each property-advantage association
 * @property int $property_id Foreign key to the properties table
 * @property int $advantage_id Foreign key to the advantages table
 *
 * @property Advantages $advantage
 * @property Properties $property
 */
class PropertyAdvantages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_advantages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'advantage_id'], 'required'],
            [['property_id', 'advantage_id'], 'integer'],
            [['property_id', 'advantage_id'], 'unique', 'targetAttribute' => ['property_id', 'advantage_id']],
            [['advantage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advantages::class, 'targetAttribute' => ['advantage_id' => 'advantage_id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_advantage_id' => 'Property Advantage ID',
            'property_id' => 'Property ID',
            'advantage_id' => 'Advantage ID',
        ];
    }

    /**
     * Gets query for [[Advantage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvantage()
    {
        return $this->hasOne(Advantages::class, ['advantage_id' => 'advantage_id']);
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
