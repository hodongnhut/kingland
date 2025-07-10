<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_roles".
 *
 * @property int $id
 * @property string $name
 *
 * @property OwnerContacts[] $ownerContacts
 */
class ContactRoles extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[OwnerContacts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwnerContacts()
    {
        return $this->hasMany(OwnerContacts::class, ['role_id' => 'id']);
    }

}
