<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_activities".
 *
 * @property int $id
 * @property int $user_id
 * @property string $action_type
 * @property int $count
 * @property string $created_at
 *
 * @property User $user
 */
class UserActivities extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_activities';
    }

    public function rules()
    {
        return [
            [['user_id', 'action_type', 'created_at'], 'required'],
            [['user_id', 'count'], 'integer'],
            [['action_type'], 'in', 'range' => ['add_new', 'view_phone', 'update_property', 'download_file']],
            [['created_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'action_type' => Yii::t('app', 'Action Type'),
            'count' => Yii::t('app', 'Count'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
?>