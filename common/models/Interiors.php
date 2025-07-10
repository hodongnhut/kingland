<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "interiors".
 *
 * @property int $interior_id ID định danh duy nhất cho nội thất
 * @property string $name Tên của nội thất
 *
 * @property Properties[] $properties
 * @property PropertyInteriors[] $propertyInteriors
 */
class Interiors extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interiors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['interior_id', 'name'], 'required'],
            [['interior_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['interior_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'interior_id' => 'Interior ID',
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
        return $this->hasMany(Properties::class, ['property_id' => 'property_id'])->viaTable('property_interiors', ['interior_id' => 'interior_id']);
    }

    /**
     * Gets query for [[PropertyInteriors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyInteriors()
    {
        return $this->hasMany(PropertyInteriors::class, ['interior_id' => 'interior_id']);
    }

}
