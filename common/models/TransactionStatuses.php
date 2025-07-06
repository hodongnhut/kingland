<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction_statuses".
 *
 * @property int $transaction_status_id Unique identifier for the transaction status
 * @property string $status_name Name of the transaction status
 *
 * @property Properties[] $properties
 */
class TransactionStatuses extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name'], 'required'],
            [['status_name'], 'string', 'max' => 100],
            [['status_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transaction_status_id' => 'Transaction Status ID',
            'status_name' => 'Status Name',
        ];
    }

    /**
     * Gets query for [[Properties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Properties::class, ['transaction_status_id' => 'transaction_status_id']);
    }

}
