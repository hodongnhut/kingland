<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property int $id
 * @property string $code Mã tiền tệ ( VND, USD)
 * @property string $name Tên tiền tệ
 */
class Currencies extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 50],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

}
