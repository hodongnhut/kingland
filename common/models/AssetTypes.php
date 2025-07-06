<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asset_types".
 *
 * @property int $asset_type_id Unique identifier for the asset type
 * @property string $type_name Name of the asset type
 *
 * @property Properties[] $properties
 */
class AssetTypes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_types';
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
            'asset_type_id' => 'Asset Type ID',
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
        return $this->hasMany(Properties::class, ['asset_type_id' => 'asset_type_id']);
    }

}
