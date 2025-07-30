<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_update_log".
 *
 * @property int $id
 * @property int $property_id
 * @property string $data
 * @property int $created_at
 * @property int|null $created_by
 * @property string|null $rendered_html_content
 */
class PropertyUpdateLog extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_update_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by', 'rendered_html_content'], 'default', 'value' => null],
            [['property_id', 'data', 'created_at'], 'required'],
            [['property_id', 'created_at', 'created_by'], 'integer'],
            [['data', 'rendered_html_content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'data' => 'Data',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'rendered_html_content' => 'Rendered Html Content',
        ];
    }


    public function getProperty()
    {
        return $this->hasOne(Properties::class, ['property_id' => 'property_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

}
