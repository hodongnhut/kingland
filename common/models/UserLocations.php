<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_locations".
 *
 * @property int $id
 * @property int $user_id
 * @property float $latitude
 * @property float $longitude
 * @property string $created_at
 *
 * @property User $user
 */
class UserLocations extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_locations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'latitude', 'longitude'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['device_type', 'os', 'browser'], 'string', 'max' => 50],
            [['device_unique_id', 'session_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
