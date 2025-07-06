<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advantages".
 *
 * @property int $advantage_id Unique identifier for the advantage
 * @property string $name Name of the advantage (e.g., "Nhà Mới Xây")
 *
 * @property Properties[] $properties
 * @property PropertyAdvantages[] $propertyAdvantages
 */
class Advantages extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advantages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'advantage_id' => 'Advantage ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Properties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Properties::class, ['property_id' => 'property_id'])->viaTable('property_advantages', ['advantage_id' => 'advantage_id']);
    }

    /**
     * Gets query for [[PropertyAdvantages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyAdvantages()
    {
        return $this->hasMany(PropertyAdvantages::class, ['advantage_id' => 'advantage_id']);
    }

}
