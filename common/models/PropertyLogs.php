<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_logs".
 *
 * @property int $property_logs_id Khóa chính tự tăng của bảng log
 * @property int $property_id Khóa ngoại, liên kết đến properties.property_id
 * @property string $history_external_id ID gốc từ web (data-id)
 * @property string|null $external_timestamp_text Thời gian hiển thị dạng text trên web
 * @property string $body_html Lưu toàn bộ nội dung HTML của khối div.GrItems
 * @property string $created_at Thời điểm log được tạo lần đầu
 * @property string $last_updated_at Thời điểm log được cập nhật lần cuối
 *
 * @property Properties $property
 */
class PropertyLogs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['external_timestamp_text'], 'default', 'value' => null],
            [['property_id', 'history_external_id', 'body_html'], 'required'],
            [['property_id'], 'integer'],
            [['body_html'], 'string'],
            [['created_at', 'last_updated_at'], 'safe'],
            [['history_external_id', 'external_timestamp_text'], 'string', 'max' => 255],
            [['history_external_id'], 'unique'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_logs_id' => 'Property Logs ID',
            'property_id' => 'Property ID',
            'history_external_id' => 'History External ID',
            'external_timestamp_text' => 'External Timestamp Text',
            'body_html' => 'Body Html',
            'created_at' => 'Created At',
            'last_updated_at' => 'Last Updated At',
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

}
