<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "owner_contacts".
 *
 * @property int $contact_id ID tự tăng, khóa chính
 * @property int $property_id Khóa ngoại, liên kết đến bất động sản
 * @property string|null $contact_name Tên người liên hệ (ví dụ: Anh Bảy, Chị Tâm)
 * @property string|null $phone_number Số điện thoại của người liên hệ
 * @property int|null $role_id
 * @property int|null $gender_id
 *
 * @property Genders $gender
 * @property Properties $property
 * @property ContactRoles $role
 */
class OwnerContacts extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'owner_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_name', 'phone_number', 'role_id', 'gender_id'], 'default', 'value' => null],
            [['property_id'], 'required'],
            [['property_id', 'role_id', 'gender_id'], 'integer'],
            [['contact_name'], 'string', 'max' => 255],
            [['phone_number'], 'string', 'max' => 20],
            [['property_id', 'phone_number'], 'unique', 'targetAttribute' => ['property_id', 'phone_number']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genders::class, 'targetAttribute' => ['gender_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContactRoles::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contact_id' => 'Contact ID',
            'property_id' => 'Property ID',
            'contact_name' => 'Tên',
            'phone_number' => 'Số Điện Thoại',
            'role_id' => 'Vai Trò',
            'gender_id' => 'Giới Tính',
        ];
    }

    /**
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Genders::class, ['id' => 'gender_id']);
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

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(ContactRoles::class, ['id' => 'role_id']);
    }

}
