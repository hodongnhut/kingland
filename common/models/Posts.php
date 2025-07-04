<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $post_id
 * @property int $category_id
 * @property string $post_title
 * @property string|null $post_content
 * @property string $post_type
 * @property string $post_date
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $is_active
 *
 * @property Attachments[] $attachments
 * @property Categories $category
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * ENUM field values
     */
    const POST_TYPE_DOC = 'DOC';
    const POST_TYPE_NEWS = 'NEWS';
    const POST_TYPE_EVENT = 'EVENT';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_content'], 'default', 'value' => null],
            [['is_active'], 'default', 'value' => 1],
            [['category_id', 'post_title', 'post_type', 'post_date'], 'required', 'message' => '{attribute} không được để trống.'],
            [['category_id', 'is_active'], 'integer', 'message' => '{attribute} phải là số nguyên.'],
            [['post_content', 'post_type'], 'string'],
            [['post_date', 'created_at', 'updated_at'], 'safe'],
            [['post_title'], 'string', 'max' => 255, 'tooLong' => '{attribute} không được vượt quá 255 ký tự.'],
            ['post_type', 'in', 'range' => array_keys(self::optsPostType()), 'message' => '{attribute} không hợp lệ.'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id'], 'message' => 'Danh mục không tồn tại.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Mã Tin Nội Bộ',
            'category_id' => 'Danh Mục',
            'post_title' => 'Tiêu Đề',
            'post_content' => 'Nội Dung',
            'post_type' => 'Kiểu',
            'post_date' => 'Ngày Đăng',
            'created_at' => 'Ngày Tạo',
            'updated_at' => 'Ngày Cập Nhật',
            'is_active' => 'Trạng Thái',
        ];
    }

    /**
     * Gets query for [[Attachments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttachments()
    {
        return $this->hasMany(Attachments::class, ['post_id' => 'post_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['category_id' => 'category_id']);
    }

    /**
     * column post_type ENUM value labels
     * @return string[]
     */
    public static function optsPostType()
    {
        return [
            self::POST_TYPE_DOC => 'Tài Liệu',
            self::POST_TYPE_NEWS => 'Tin Tức',
            self::POST_TYPE_EVENT => 'Sự Kiện',
        ];
    }

    /**
     * @return string
     */
    public function displayPostType()
    {
        return self::optsPostType()[$this->post_type];
    }

    /**
     * @return bool
     */
    public function isPostTypeDoc()
    {
        return $this->post_type === self::POST_TYPE_DOC;
    }

    public function setPostTypeToDoc()
    {
        $this->post_type = self::POST_TYPE_DOC;
    }

    /**
     * @return bool
     */
    public function isPostTypeNews()
    {
        return $this->post_type === self::POST_TYPE_NEWS;
    }

    public function setPostTypeToNews()
    {
        $this->post_type = self::POST_TYPE_NEWS;
    }

    /**
     * @return bool
     */
    public function isPostTypeEvent()
    {
        return $this->post_type === self::POST_TYPE_EVENT;
    }

    public function setPostTypeToEvent()
    {
        $this->post_type = self::POST_TYPE_EVENT;
    }
}