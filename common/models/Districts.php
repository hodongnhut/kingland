<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Districts".
 *
 * @property int $id
 * @property string|null $TCTKid
 * @property string $Name
 * @property string|null $ProvinceId
 * @property string|null $Prefix
 * @property string|null $Keyword
 * @property string|null $latlng
 * @property string|null $Lookup
 */
class Districts extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TCTKid', 'ProvinceId', 'Prefix', 'Keyword', 'latlng', 'Lookup'], 'default', 'value' => null],
            [['id', 'Name'], 'required'],
            [['id'], 'integer'],
            [['TCTKid', 'ProvinceId'], 'string', 'max' => 10],
            [['Name', 'Lookup'], 'string', 'max' => 100],
            [['Prefix'], 'string', 'max' => 20],
            [['Keyword', 'latlng'], 'string', 'max' => 50],
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
            'TCTKid' => 'Tct Kid',
            'Name' => 'Name',
            'ProvinceId' => 'Province ID',
            'Prefix' => 'Prefix',
            'Keyword' => 'Keyword',
            'latlng' => 'Latlng',
            'Lookup' => 'Lookup',
        ];
    }

}
