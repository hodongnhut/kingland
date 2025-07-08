<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Streets".
 *
 * @property int $id
 * @property string $Name
 * @property string|null $Name_vi_Old
 * @property string|null $Keyword_Old
 * @property string|null $ProvinceId
 * @property string|null $DistrictId
 * @property string|null $Prefix
 * @property string|null $Keyword
 * @property string|null $Lookup
 */
class Streets extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Streets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name_vi_Old', 'Keyword_Old', 'ProvinceId', 'DistrictId', 'Prefix', 'Keyword', 'Lookup'], 'default', 'value' => null],
            [['id', 'Name'], 'required'],
            [['id'], 'integer'],
            [['Name', 'Name_vi_Old', 'Keyword_Old', 'Keyword'], 'string', 'max' => 100],
            [['ProvinceId', 'DistrictId'], 'string', 'max' => 10],
            [['Prefix'], 'string', 'max' => 50],
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
            'Name_vi_Old' => 'Name Vi Old',
            'Keyword_Old' => 'Keyword Old',
            'ProvinceId' => 'Province ID',
            'DistrictId' => 'District ID',
            'Prefix' => 'Prefix',
            'Keyword' => 'Keyword',
            'Lookup' => 'Lookup',
        ];
    }

}
