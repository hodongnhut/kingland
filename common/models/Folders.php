<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "folders".
 *
 * @property int $id
 * @property string $name_folder
 * @property int|null $parent_folder_id
 * @property string|null $noted
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $create_by
 *
 * @property User $createBy
 * @property Folders[] $folders
 * @property Folders $parentFolder
 */
class Folders extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'folders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_folder_id', 'noted', 'create_by'], 'default', 'value' => null],
            [['name_folder'], 'required'],
            [['parent_folder_id', 'create_by'], 'integer'],
            [['noted'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name_folder'], 'string', 'max' => 255],
            [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['create_by' => 'id']],
            [['parent_folder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Folders::class, 'targetAttribute' => ['parent_folder_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_folder' => 'Name Folder',
            'parent_folder_id' => 'Parent Folder ID',
            'noted' => 'Noted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'create_by' => 'Create By',
        ];
    }

    /**
     * Gets query for [[CreateBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreateBy()
    {
        return $this->hasOne(User::class, ['id' => 'create_by']);
    }

    /**
     * Gets query for [[Folders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFolders()
    {
        return $this->hasMany(Folders::class, ['parent_folder_id' => 'id']);
    }

    /**
     * Gets query for [[ParentFolder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentFolder()
    {
        return $this->hasOne(Folders::class, ['id' => 'parent_folder_id']);
    }

}
