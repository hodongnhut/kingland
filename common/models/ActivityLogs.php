<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activity_logs".
 *
 * @property int $log_id ID tự tăng, khóa chính của log
 * @property int $property_id Khóa ngoại, liên kết đến BĐS được tương tác
 * @property int $user_id Khóa ngoại, liên kết đến nhân viên thực hiện hành động
 * @property int|null $contact_id Khóa ngoại, liên kết đến liên hệ chủ nhà đã xem SĐT
 * @property string $action_type Loại hành động, ví dụ: "Xem số điện thoại", "Thêm mới BĐS"
 * @property string|null $details Chi tiết bổ sung, ví dụ: "SĐT đã xem: 090...123"
 * @property string $created_at Thời gian xảy ra hành động
 *
 * @property Properties $property
 * @property User $user
 */
class ActivityLogs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'details'], 'default', 'value' => null],
            [['property_id', 'user_id', 'action_type'], 'required'],
            [['property_id', 'user_id', 'contact_id'], 'integer'],
            [['details'], 'string'],
            [['created_at'], 'safe'],
            [['action_type'], 'string', 'max' => 100],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'property_id' => 'Property ID',
            'user_id' => 'User ID',
            'contact_id' => 'Contact ID',
            'action_type' => 'Action Type',
            'details' => 'Details',
            'created_at' => 'Created At',
        ];
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
