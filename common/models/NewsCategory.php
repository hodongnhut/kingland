<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "news_categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 */
class NewsCategory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_categories'; // Tên bảng nhóm tin tức
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Tên nhóm không được để trống.'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['name'], 'unique', 'message' => 'Tên nhóm này đã tồn tại.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên Nhóm',
            'description' => 'Mô Tả',
        ];
    }
}
