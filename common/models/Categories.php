<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $category_id
 * @property string $category_name
 * @property string|null $description
 *
 * @property Posts[] $posts
 */
class Categories extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['category_name'], 'required'],
            [['description'], 'string'],
            [['category_name'], 'string', 'max' => 255],
            [['category_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['category_id' => 'category_id']);
    }

}
