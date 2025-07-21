<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_favorite".
 *
 * @property int $id
 * @property int $user_id
 * @property int $property_id
 * @property string $created_at
 * @property string $updated_at
 */
class PropertyFavorite extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_favorite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'property_id'], 'required'],
            [['user_id', 'property_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'property_id'], 'unique', 'targetAttribute' => ['user_id', 'property_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']], // Assuming Property.php is the model for 'properties' table
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
            'property_id' => 'Property ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Properties::class, ['property_id' => 'property_id']);
    }

}
