<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "news_articles".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $content
 * @property string|null $image_path
 * @property int $status // e.g., 0: Draft, 1: Published
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property NewsCategory $category
 * @property User $createdBy
 * @property User $updatedBy
 */
class News extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_articles'; // Tên bảng tin tức trong cơ sở dữ liệu của bạn
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'content', 'status', 'created_at', 'updated_at'], 'required', 'message' => '{attribute} không được để trống.'],
            [['category_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['content'], 'string'],
            [['title', 'slug', 'short_description', 'image_path'], 'string', 'max' => 255],
            [['slug'], 'unique', 'message' => 'Slug này đã tồn tại.'],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_PUBLISHED]],

            // Quan hệ với NewsCategory
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            // Quan hệ với User (người tạo/cập nhật)
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Nhóm Bản Tin',
            'title' => 'Tiêu Đề',
            'slug' => 'Slug',
            'short_description' => 'Mô Tả Ngắn',
            'content' => 'Nội Dung',
            'image_path' => 'Đường Dẫn Hình Ảnh',
            'status' => 'Trạng Thái',
            'created_at' => 'Ngày Tạo',
            'updated_at' => 'Ngày Cập Nhật',
            'created_by' => 'Người Tạo',
            'updated_by' => 'Người Cập Nhật',
        ];
    }

    /**
     * Quan hệ với NewsCategory.
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(NewsCategory::class, ['id' => 'category_id']);
    }

    /**
     * Quan hệ với User (người tạo).
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Quan hệ với User (người cập nhật).
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * Tự động tạo slug trước khi lưu.
     * Tự động cập nhật created_at, updated_at và created_by, updated_by.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
                $this->created_by = Yii::$app->user->id;
                // Generate slug if not set
                if (empty($this->slug)) {
                    $this->slug = \yii\helpers\Inflector::slug($this->title);
                }
            }
            $this->updated_at = time();
            $this->updated_by = Yii::$app->user->id;
            return true;
        }
        return false;
    }
}
