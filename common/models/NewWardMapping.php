<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "New_Ward_Mapping".
 *
 * @property int $New_ID
 * @property string $New_Name
 * @property string|null $New_Type
 * @property float|null $New_Area_km2
 * @property int|null $New_Population
 * @property string|null $Old_IDs
 * @property string|null $Old_Names
 * @property string|null $Old_Districts
 * @property string|null $Old_Cities
 * @property string $created_at
 */
class NewWardMapping extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'new_ward_mapping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['New_Type', 'New_Area_km2', 'New_Population', 'Old_IDs', 'Old_Names', 'Old_Districts', 'Old_Cities'], 'default', 'value' => null],
            [['New_ID', 'New_Name'], 'required'],
            [['New_ID', 'New_Population'], 'integer'],
            [['New_Area_km2'], 'number'],
            [['Old_IDs', 'Old_Names', 'Old_Districts', 'Old_Cities'], 'string'],
            [['created_at'], 'safe'],
            [['New_Name'], 'string', 'max' => 255],
            [['New_Type'], 'string', 'max' => 100],
            [['New_ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'New_ID' => 'New ID',
            'New_Name' => 'New Name',
            'New_Type' => 'New Type',
            'New_Area_km2' => 'New Area Km2',
            'New_Population' => 'New Population',
            'Old_IDs' => 'Old I Ds',
            'Old_Names' => 'Old Names',
            'Old_Districts' => 'Old Districts',
            'Old_Cities' => 'Old Cities',
            'created_at' => 'Created At',
        ];
    }

}
