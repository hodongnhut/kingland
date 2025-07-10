<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "genders".
 *
 * @property int $id
 * @property string $name
 *
 * @property OwnerContacts[] $ownerContacts
 */
class Genders extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
        return $this->hasMany(OwnerContacts::class, ['gender_id' => 'id']);
    }

}
