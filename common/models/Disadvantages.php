<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "disadvantages".
 *
 * @property int $disadvantage_id Unique identifier for the disadvantage
 * @property string $disadvantage_name Description of the disadvantage (e.g., Đất Bị Quy Hoạch, Có Trụ Điện)
 *
 * @property Properties[] $properties
 * @property PropertyDisadvantages[] $propertyDisadvantages
 */
class Disadvantages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disadvantages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disadvantage_name'], 'required'],
            [['disadvantage_name'], 'string', 'max' => 255],
            [['disadvantage_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'disadvantage_id' => 'Disadvantage ID',
            'disadvantage_name' => 'Disadvantage Name',
        ];
    }

    /**
     * Gets query for [[Properties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Properties::class, ['property_id' => 'property_id'])->viaTable('property_disadvantages', ['disadvantage_id' => 'disadvantage_id']);
    }

    /**
     * Gets query for [[PropertyDisadvantages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyDisadvantages()
    {
        return $this->hasMany(PropertyDisadvantages::class, ['disadvantage_id' => 'disadvantage_id']);
    }

}
