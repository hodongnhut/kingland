<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "listing".
 *
 * @property int $id
 * @property string|null $listing_types_id
 * @property string|null $house_number
 * @property string|null $street_name
 * @property string|null $ward_commune
 * @property string|null $district_county
 * @property string|null $city
 * @property string|null $phone1
 * @property string|null $phone2
 * @property string|null $phone3
 * @property string|null $phone4
 * @property string|null $phone5
 * @property string|null $phone6
 * @property string|null $price
 * @property string|null $final_price
 * @property string|null $area_total
 * @property string|null $area_width
 * @property string|null $area_length
 * @property string|null $rent_price
 * @property string|null $num_floors
 * @property string|null $location_type_id
 * @property string|null $property_type_id
 * @property string|null $land_type_id
 * @property string|null $transaction_description
 * @property string|null $asset_type_id
 * @property string|null $transaction_status_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Listing extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['listing_types_id', 'house_number', 'street_name', 'ward_commune', 'district_county', 'city', 'phone1', 'phone2', 'phone3', 'phone4', 'phone5', 'phone6', 'price', 'final_price', 'area_total', 'area_width', 'area_length', 'rent_price', 'num_floors', 'location_type_id', 'property_type_id', 'land_type_id', 'transaction_description', 'asset_type_id', 'transaction_status_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['transaction_description'], 'string'],
            [['listing_types_id', 'house_number', 'street_name', 'ward_commune', 'district_county', 'city', 'phone1', 'phone2', 'phone3', 'phone4', 'phone5', 'phone6', 'price', 'final_price', 'area_total', 'area_width', 'area_length', 'rent_price', 'num_floors', 'location_type_id', 'property_type_id', 'land_type_id', 'asset_type_id', 'transaction_status_id', 'created_at', 'updated_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'listing_types_id' => 'Listing Types ID',
            'house_number' => 'House Number',
            'street_name' => 'Street Name',
            'ward_commune' => 'Ward Commune',
            'district_county' => 'District County',
            'city' => 'City',
            'phone1' => 'Phone1',
            'phone2' => 'Phone2',
            'phone3' => 'Phone3',
            'phone4' => 'Phone4',
            'phone5' => 'Phone5',
            'phone6' => 'Phone6',
            'price' => 'Price',
            'final_price' => 'Final Price',
            'area_total' => 'Area Total',
            'area_width' => 'Area Width',
            'area_length' => 'Area Length',
            'rent_price' => 'Rent Price',
            'num_floors' => 'Num Floors',
            'location_type_id' => 'Location Type ID',
            'property_type_id' => 'Property Type ID',
            'land_type_id' => 'Land Type ID',
            'transaction_description' => 'Transaction Description',
            'asset_type_id' => 'Asset Type ID',
            'transaction_status_id' => 'Transaction Status ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
