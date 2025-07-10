<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_disadvantages".
 *
 * @property int $property_disadvantages_id Auto-increment primary key
 * @property int $property_id Foreign key to the properties table
 * @property int $disadvantage_id Foreign key to the disadvantages table
 *
 * @property Disadvantages $disadvantage
 * @property Properties $property
 */
class PropertyDisadvantages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_disadvantages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'disadvantage_id'], 'required'],
            [['property_id', 'disadvantage_id'], 'integer'],
            [['property_id', 'disadvantage_id'], 'unique', 'targetAttribute' => ['property_id', 'disadvantage_id']],
            [['disadvantage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Disadvantages::class, 'targetAttribute' => ['disadvantage_id' => 'disadvantage_id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_disadvantages_id' => 'Property Disadvantages ID',
            'property_id' => 'Property ID',
            'disadvantage_id' => 'Disadvantage ID',
        ];
    }

    /**
     * Gets query for [[Disadvantage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisadvantage()
    {
        return $this->hasOne(Disadvantages::class, ['disadvantage_id' => 'disadvantage_id']);
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
