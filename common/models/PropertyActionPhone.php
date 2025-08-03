<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_action_phone".
 *
 * @property int $id
 * @property int $property_id
 * @property int $user_id
 * @property string $action
 * @property string $phone_number
 * @property string $timestamp
 */
class PropertyActionPhone extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ACTION_CREATE = 'create';
    const ACTION_VIEW = 'view';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_action_phone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'user_id', 'action', 'phone_number'], 'required'],
            [['property_id', 'user_id'], 'integer'],
            [['action'], 'string'],
            [['timestamp'], 'safe'],
            [['phone_number'], 'string', 'max' => 20],
            ['action', 'in', 'range' => array_keys(self::optsAction())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'phone_number' => 'Phone Number',
            'timestamp' => 'Timestamp',
        ];
    }


    /**
     * column action ENUM value labels
     * @return string[]
     */
    public static function optsAction()
    {
        return [
            self::ACTION_CREATE => 'create',
            self::ACTION_VIEW => 'view',
        ];
    }

    /**
     * @return string
     */
    public function displayAction()
    {
        return self::optsAction()[$this->action];
    }

    /**
     * @return bool
     */
    public function isActionCreate()
    {
        return $this->action === self::ACTION_CREATE;
    }

    public function setActionToCreate()
    {
        $this->action = self::ACTION_CREATE;
    }

    /**
     * @return bool
     */
    public function isActionView()
    {
        return $this->action === self::ACTION_VIEW;
    }

    public function setActionToView()
    {
        $this->action = self::ACTION_VIEW;
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Properties::class, ['property_id' => 'property_id']);
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
