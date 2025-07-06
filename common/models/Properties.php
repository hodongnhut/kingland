<?php

namespace common\models;


use Yii;
// use common\models\AssetTypes;

/**
 * This is the model class for table "properties".
 *
 * @property int $property_id Unique identifier for the property
 * @property int $user_id Foreign key to the user table (who manages/created this property)
 * @property string|null $title General title for the property listing
 * @property int|null $property_type_id [FK] Loại sản phẩm
 * @property int|null $has_vat_invoice Indicates if the property comes with a VAT invoice (0=No, 1=Yes)
 * @property string|null $house_number Số nhà
 * @property string|null $street_name Đưởng phố
 * @property string|null $ward_commune phường
 * @property string|null $district_county tỉnh
 * @property string|null $city thành phố
 * @property int|null $location_type_id [FK] Vị trí (Vị trí BĐS)
 * @property string|null $compound_name Name of the compound, if applicable
 * @property float|null $area_width Ngang (Diện tích đất)
 * @property float|null $area_length Dài (Diện tích đất)
 * @property float|null $area_total DT Công Nhận (Diện tích đất)
 * @property float|null $planned_width Ngang (Diện tích quy hoạch)
 * @property float|null $planned_length Dài (Diện tích quy hoạch)
 * @property float|null $planned_construction_area Diện tích xây dựng (Diện tích quy hoạch)
 * @property string|null $usable_area DT sử dụng (Thông tin khác)
 * @property string|null $direction Hướng (Thông tin khác)
 * @property string|null $land_type Loại đất (Thông tin khác)
 * @property int|null $num_toilets Số WC (Thông tin khác)
 * @property int|null $num_bedrooms Số phòng ngủ (Thông tin khác)
 * @property int|null $num_basements Số Tầng hầm (Thông tin khác)
 * @property int|null $asset_type_id [FK] Loại tài sản (Loại tài sản)
 * @property string|null $description Detailed description of the property
 * @property int|null $has_deposit Indicates if a deposit has been placed (0=No, 1=Yes)
 * @property int|null $transaction_status_id [FK] transaction_statuses
 * @property string|null $transaction_description Additional description for transaction status
 * @property int|null $has_rental_contract Hợp đồng thuê
 * @property int|null $is_active General listing status (0=Inactive, 1=Active)
 * @property int $created_at Thời gian tạo
 * @property int $updated_at Thời gian cập nhật
 * @property string|null $external_id ID bên ngoài (ID Crawl)
 * @property int|null $num_floors Số Tầng Hầm (Thông tin khác)
 * @property string|null $plot_number Số thửa (Giá)
 * @property string|null $sheet_number Số tờ (Giá)
 * @property string|null $lot_number Số lô (Giá)
 * @property int|null $commission_types_id [FK] Loại hoa hồng (commission_prices)
 * @property int|null $commission_prices_id [FK] (commission_prices)
 * @property float|null $area_back_side Mặt hậu (Diện tích)
 * @property float|null $wide_road Đường rộng (Thông tin khác)
 * @property float|null $planned_back_side Mặt hậu (Diện tích quy hoạch)
 * @property int|null $property_images_id [FK] Image (property_images)
 *
 * @property LocationTypes $locationType
 * @property PropertyTypes $propertyType
 * @property User $user
 */
class Properties extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'property_type_id', 'house_number', 'street_name', 'ward_commune', 'district_county', 'location_type_id', 'compound_name', 'area_width', 'area_length', 'area_total', 'planned_width', 'planned_length', 'planned_construction_area', 'usable_area', 'direction', 'land_type', 'num_toilets', 'num_bedrooms', 'num_basements', 'asset_type_id', 'description', 'transaction_status_id', 'transaction_description', 'external_id', 'num_floors', 'plot_number', 'sheet_number', 'lot_number', 'commission_types_id', 'commission_prices_id', 'area_back_side', 'wide_road', 'planned_back_side', 'property_images_id'], 'default', 'value' => null],
            [['has_rental_contract'], 'default', 'value' => 0],
            [['city'], 'default', 'value' => 'Hồ Chí Minh'],
            [['is_active'], 'default', 'value' => 1],
            [['user_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'property_type_id', 'has_vat_invoice', 'location_type_id', 'num_toilets', 'num_bedrooms', 'num_basements', 'has_deposit', 'transaction_status_id', 'has_rental_contract', 'is_active','num_floors', 'commission_types_id', 'commission_prices_id', 'property_images_id'], 'integer'],
            [['area_width', 'area_length', 'area_total', 'planned_width', 'planned_length', 'planned_construction_area', 'area_back_side', 'wide_road', 'planned_back_side'], 'number'],
            [['description', 'transaction_description'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['house_number', 'usable_area', 'direction', 'land_type', 'plot_number', 'sheet_number', 'lot_number'], 'string', 'max' => 50],
            [['street_name', 'compound_name', 'external_id'], 'string', 'max' => 255],
            [['ward_commune', 'district_county', 'city'], 'string', 'max' => 100],
            [['location_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocationTypes::class, 'targetAttribute' => ['location_type_id' => 'location_type_id']],
            [['property_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyTypes::class, 'targetAttribute' => ['property_type_id' => 'property_type_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Directions::class, 'targetAttribute' => ['direction_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'property_id' => 'Property ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'property_type_id' => 'Property Type ID',
            'price' => 'Selling Price',
            'has_vat_invoice' => 'Has Vat Invoice',
            'house_number' => 'House Number',
            'street_name' => 'Street Name',
            'ward_commune' => 'Ward Commune',
            'district_county' => 'District County',
            'city' => 'City',
            'location_type_id' => 'Location Type ID',
            'compound_name' => 'Compound Name',
            'area_width' => 'Area Width',
            'area_length' => 'Area Length',
            'area_total' => 'Area Total',
            'planned_width' => 'Planned Width',
            'planned_length' => 'Planned Length',
            'planned_construction_area' => 'Planned Construction Area',
            'usable_area' => 'Usable Area',
            'direction' => 'Direction',
            'land_type' => 'Land Type',
            'num_toilets' => 'Num Toilets',
            'num_bedrooms' => 'Num Bedrooms',
            'num_basements' => 'Num Basements',
            'asset_type_id' => 'Asset Type ID',
            'description' => 'Description',
            'has_deposit' => 'Has Deposit',
            'transaction_status_id' => 'Transaction Status ID',
            'transaction_description' => 'Transaction Description',
            'has_rental_contract' => 'Has Rental Contract',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'external_id' => 'External ID',
            'num_floors' => 'Num Floors',
            'plot_number' => 'Plot Number',
            'sheet_number' => 'Sheet Number',
            'lot_number' => 'Lot Number',
            'commission_types_id' => 'Commission Types ID',
            'commission_prices_id' => 'Commission Prices ID',
            'area_back_side' => 'Area Back Side',
            'wide_road' => 'Wide Road',
            'planned_back_side' => 'Planned Back Side',
            'property_images_id' => 'Property Images ID',
            'direction_id' => 'Direction ID',
        ];
    }

    /**
     * Gets query for [[LocationType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocationType()
    {
        return $this->hasOne(LocationTypes::class, ['location_type_id' => 'location_type_id']);
    }

    /**
     * Gets query for [[PropertyType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyType()
    {
        return $this->hasOne(PropertyTypes::class, ['property_type_id' => 'property_type_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[TransactionStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionStatus()
    {
        return $this->hasOne(TransactionStatuses::class, ['transaction_status_id' => 'transaction_status_id']);
    }

    public function getDirection()
    {
        return $this->hasOne(Directions::class, ['id' => 'direction_id']);
    }

    public function getAssetType()
    {
        // Giả sử khóa ngoại trong bảng 'properties' là 'asset_type_id'
        // và nó liên kết đến 'asset_type_id' trong bảng của AssetType.
        return $this->hasOne(AssetTypes::class, ['asset_type_id' => 'asset_type_id']);
    }

}
