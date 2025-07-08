<?php

namespace common\models;

use Yii;

/**
 * Đây là lớp mô hình cho bảng "folders".
 *
 * @property int $id                 -- ID duy nhất của thư mục
 * @property string $name_folder     -- Tên của thư mục (ví dụ: "NhaDat", "Documents", "Reports")
 * @property int|null $parent_folder_id -- ID của thư mục cha; NULL nếu là thư mục gốc
 * @property string|null $noted      -- Ghi chú hoặc mô tả về thư mục
 * @property string $created_at      -- Thời điểm tạo thư mục
 * @property string $updated_at      -- Thời điểm cập nhật thư mục gần nhất
 * @property int|null $create_by     -- ID của người dùng đã tạo thư mục
 *
 * @property User $createBy          -- Mối quan hệ với người dùng đã tạo
 * @property Folders[] $folders      -- Mảng các thư mục con
 * @property Folders $parentFolder   -- Thư mục cha
 */
class Folders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     * Trả về tên bảng trong cơ sở dữ liệu.
     */
    public static function tableName()
    {
        return 'folders';
    }

    /**
     * {@inheritdoc}
     * Định nghĩa các quy tắc xác thực cho các thuộc tính của mô hình.
     */
    public function rules()
    {
        return [
            // Đặt giá trị mặc định là NULL cho các trường không bắt buộc
            [['parent_folder_id', 'noted', 'create_by'], 'default', 'value' => null],
            // 'name_folder' là trường bắt buộc
            [['name_folder'], 'required', 'message' => '{attribute} không được để trống.'],
            // 'parent_folder_id' và 'create_by' phải là số nguyên
            [['parent_folder_id', 'create_by'], 'integer', 'message' => '{attribute} phải là số nguyên.'],
            // 'noted' phải là chuỗi
            [['noted'], 'string', 'message' => '{attribute} phải là chuỗi văn bản.'],
            // 'created_at' và 'updated_at' là các trường an toàn (thường được DB tự động quản lý)
            [['created_at', 'updated_at'], 'safe'],
            // 'name_folder' phải là chuỗi và có độ dài tối đa 255 ký tự
            [['name_folder'], 'string', 'max' => 255, 'message' => '{attribute} không được vượt quá 255 ký tự.'],
            // Xác thực rằng 'create_by' phải tồn tại trong bảng 'User'
            [['create_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['create_by' => 'id'], 'message' => 'Người tạo không hợp lệ.'],
            // Xác thực rằng 'parent_folder_id' phải tồn tại trong bảng 'Folders' (thư mục cha)
            [['parent_folder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Folders::class, 'targetAttribute' => ['parent_folder_id' => 'id'], 'message' => 'Thư mục cha không hợp lệ.'],
        ];
    }

    /**
     * {@inheritdoc}
     * Trả về các nhãn thuộc tính thân thiện với người dùng.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã Thư Mục',
            'name_folder' => 'Tên Thư Mục',
            'parent_folder_id' => 'Thư Mục Cha',
            'noted' => 'Ghi Chú',
            'created_at' => 'Thời Gian Tạo',
            'updated_at' => 'Thời Gian Cập Nhật',
            'create_by' => 'Người Tạo',
        ];
    }

    /**
     * Lấy truy vấn cho mối quan hệ [[CreateBy]] (Người Tạo).
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreateBy()
    {
        return $this->hasOne(User::class, ['id' => 'create_by']);
    }

    /**
     * Lấy truy vấn cho mối quan hệ [[Folders]] (Thư Mục Con).
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFolders()
    {
        return $this->hasMany(Folders::class, ['parent_folder_id' => 'id']);
    }

    /**
     * Lấy truy vấn cho mối quan hệ [[ParentFolder]] (Thư Mục Cha).
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentFolder()
    {
        return $this->hasOne(Folders::class, ['id' => 'parent_folder_id']);
    }

}
