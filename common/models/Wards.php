<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Wards".
 *
 * @property int $id
 * @property string $Name
 * @property string|null $ProvinceId
 * @property string|null $DistrictId
 * @property string|null $Prefix
 * @property string|null $Keyword
 * @property string|null $latlng
 * @property string|null $Lookup
 */
class Wards extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Wards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProvinceId', 'DistrictId', 'Prefix', 'Keyword', 'latlng', 'Lookup'], 'default', 'value' => null],
            [['id', 'Name'], 'required'],
            [['id'], 'integer'],
            [['Name', 'Keyword'], 'string', 'max' => 100],
            [['ProvinceId', 'DistrictId'], 'string', 'max' => 10],
            [['Prefix', 'latlng'], 'string', 'max' => 50],
            [['Lookup'], 'string', 'max' => 150],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Name' => 'Name',
            'ProvinceId' => 'Province ID',
            'DistrictId' => 'District ID',
            'Prefix' => 'Prefix',
            'Keyword' => 'Keyword',
            'latlng' => 'Latlng',
            'Lookup' => 'Lookup',
        ];
    }

}
