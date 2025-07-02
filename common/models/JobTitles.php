<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord; // Import ActiveRecord

/**
 * This is the model class for table "job_titles".
 *
 * @property int $job_title_id
 * @property string $title_name
 * @property string|null $role_code // Đã thêm thuộc tính role_code
 */
class JobTitles extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_titles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_name'], 'required', 'message' => 'Tên chức vụ không được để trống.'],
            [['title_name', 'role_code'], 'string', 'max' => 100, 'tooLong' => '{attribute} không được vượt quá 100 ký tự.'],
            [['title_name'], 'unique', 'message' => 'Tên chức vụ này đã tồn tại.'],
            [['role_code'], 'unique', 'message' => 'Mã vai trò này đã tồn tại.'], // Thêm quy tắc unique cho role_code
            [['role_code'], 'string', 'max' => 50, 'tooLong' => 'Mã vai trò không được vượt quá 50 ký tự.'], // Quy tắc độ dài cho role_code
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'job_title_id' => 'ID Chức vụ',
            'title_name' => 'Tên chức vụ',
            'role_code' => 'Mã vai trò',
        ];
    }
}
