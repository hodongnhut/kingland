<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Provinces".
 *
 * @property int $id
 * @property string $Name
 * @property string|null $Keyword
 * @property string|null $latlng
 * @property string|null $Lookup
 */
class Provinces extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Provinces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Keyword', 'latlng', 'Lookup'], 'default', 'value' => null],
            [['id', 'Name'], 'required'],
            [['id'], 'integer'],
            [['Name', 'Lookup'], 'string', 'max' => 100],
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
            'Name' => 'Name',
            'Keyword' => 'Keyword',
            'latlng' => 'Latlng',
            'Lookup' => 'Lookup',
        ];
    }

}
