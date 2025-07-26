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

    /**
     * Logs a user activity.
     * @param int $userId The ID of the user performing the action
     * @param string $actionType The type of action ('add_new', 'view_phone', 'update_property', 'download_file')
     * @param int $count The number of actions to log (default 1)
     * @param string|null $dateTime The timestamp of the action (default now)
     * @return bool Whether the activity was logged successfully
     */
    public static function logActivity($userId, $actionType, $count = 1, $dateTime = null)
    {
        if (!in_array($actionType, ['add_new', 'view_phone', 'update_property', 'download_file'])) {
            Yii::error("Invalid action type: $actionType", __METHOD__);
            return false;
        }
        if (!User::findOne($userId)) {
            Yii::error("User ID $userId does not exist", __METHOD__);
            return false;
        }
        $date = $dateTime ? date('Y-m-d', strtotime($dateTime)) : date('Y-m-d');
        
        $activity = self::find()
            ->where(['user_id' => $userId, 'action_type' => $actionType])
            ->andWhere(['like', 'created_at', $date])
            ->one();

        if (!$activity) {
            $activity = new self();
            $activity->user_id = $userId;
            $activity->action_type = $actionType;
            $activity->created_at = $dateTime ?: date('Y-m-d H:i:s');
        }
        $activity->count += $count;
        if ($activity->save()) {
            return true;
        } else {
            Yii::error("Failed to log activity: " . json_encode($activity->getErrors()), __METHOD__);
            return false;
        }
    }

    public static function logActivityPhone($userId, $actionType, $limit = null)
    {
        $today = date('Y-m-d');
        
        $activity = self::find()
            ->where(['user_id' => $userId, 'action_type' => $actionType])
            ->andWhere(['between', 'created_at', "$today 00:00:00", "$today 23:59:59"])
            ->one();

        if ($limit !== null && $activity && $activity->count >= $limit) {
            return false; 
        }

        if ($activity) {
            $activity->count += 1;
            $activity->save(false);
        } else {
            $activity = new self();
            $activity->user_id = $userId;
            $activity->action_type = $actionType;
            $activity->count = 1;
            $activity->created_at = date('Y-m-d H:i:s');
            $activity->save(false);
        }
        return true; 
    }

}
?>