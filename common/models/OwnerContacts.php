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
            [['contact_name', 'phone_number'], 'trim'],
            [['property_id'], 'required', 'message' => 'Vui lòng nhập ID bất động sản.'],
            [['property_id', 'role_id', 'gender_id'], 'integer'],
            [['contact_name'], 'string', 'max' => 255, 'tooLong' => 'Tên không được vượt quá 255 ký tự.'],
            [['phone_number'], 'string', 'max' => 20, 'tooLong' => 'Số điện thoại không được vượt quá 20 ký tự.'],
            [['phone_number'], 'match', 'pattern' => '/^(0[3|5|7|8|9][0-9]{8})$/', 'message' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10 chữ số, bắt đầu bằng 03, 05, 07, 08, hoặc 09).'],
            [['property_id', 'phone_number'], 'unique', 'targetAttribute' => ['property_id', 'phone_number'], 'message' => 'Số điện thoại này đã được sử dụng cho bất động sản này.'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id'], 'message' => 'Bất động sản không tồn tại.'],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genders::class, 'targetAttribute' => ['gender_id' => 'id'], 'message' => 'Giới tính không hợp lệ.'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContactRoles::class, 'targetAttribute' => ['role_id' => 'id'], 'message' => 'Vai trò không hợp lệ.'],
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
