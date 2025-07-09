<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Mẫu đăng ký tài khoản (Property Registration Form Model)
 */
class PropertiesFrom extends Model
{
    public $listing_types_id;
    public $property_type_id;
    public $provinces;
    public $districts;
    public $wards;
    public $streets;
    public $house_number;
    public $plot_number; // Corresponds to 'Số Thửa'
    public $sheet_number; // Corresponds to 'Số Tờ'
    public $lot_number;   // Corresponds to 'Số Lô'
    public $region;       // Corresponds to 'Khu Vực'

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['listing_types_id'], 'required', 'message' => 'Vui lòng chọn {attribute}!'],
            [['property_type_id', 'provinces', 'districts', 'wards', 'streets'], 'required', 'message' => '{attribute} không được để trống.'],

            ['listing_types_id', 'integer'], // Assuming it's an ID (1 for Bán, 2 for Cho Thuê)
            ['property_type_id', 'integer'], // Assuming it's an ID
            ['provinces', 'string', 'max' => 255], // Assuming province names or IDs are strings
            ['districts', 'string', 'max' => 255], // Assuming district names or IDs are strings
            ['wards', 'string', 'max' => 255],     // Assuming ward names or IDs are strings
            ['streets', 'string', 'max' => 255],   // Assuming street names or IDs are strings

            // Optional text fields
            [['house_number', 'plot_number', 'sheet_number', 'lot_number'], 'string', 'max' => 100],
            ['region', 'string', 'max' => 500], // 'Khu Vực' can be longer for description

            // Example of a default value if needed (e.g., if 'Bán' is default)
            // ['listing_types_id', 'default', 'value' => 1], // For 'Bán'
            [['property_id'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'listing_types_id' => 'Loại Giao Dịch', 
            'property_type_id' => 'Loại BĐS',
            'provinces' => 'Tỉnh Thành',
            'districts' => 'Quận Huyện',
            'wards' => 'Phường / Xã',
            'streets' => 'Đường',
            'house_number' => 'Số Nhà',
            'plot_number' => 'Số Thửa',
            'sheet_number' => 'Số Tờ',
            'lot_number' => 'Số Lô',
            'region' => 'Khu Vực',
        ];
    }


     /**
     * Tạo property
     *
     * @return bool Create property
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $property = new Properties();
        $property->user_id = Yii::$app->user->id;
        $property->listing_types_id = $this->listing_types_id;
        $property->property_type_id = $this->property_type_id;

        $property->city = Provinces::findOne($this->provinces)->Name;
        $property->district_county = Districts::findOne($this->districts)->Name;
        $property->ward_commune = Wards::findOne($this->wards)->Name;
        $property->street_name = Streets::findOne($this->streets)->Name;

        $property->house_number = $this->house_number;
        $property->plot_number = $this->plot_number;
        $property->sheet_number = $this->sheet_number;
        $property->lot_number = $this->lot_number;
        $property->region = $this->region;

        $property->created_at = date('Y-m-d H:i:s');
        $property->updated_at = date('Y-m-d H:i:s');

        return $property->save(false) ? $property : null;
    }

}