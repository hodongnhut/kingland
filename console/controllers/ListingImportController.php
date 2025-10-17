<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Listing;
use common\models\OwnerContacts;
use common\models\Properties;
use common\models\LocationTypes;
use common\models\PropertyTypes;
use common\models\LandType;

class ListingImportController extends Controller
{
    public function actionRun()
    {
        $count = 0;
        $skip = 0;

        foreach (Listing::find()->batch(100) as $listings) {
            foreach ($listings as $listing) {
                $address = '';
                // Chuẩn hóa địa chỉ để so sánh
                $address =  $listing->house_number . ' '. $listing->street_name;

                // Tìm các property có thể trùng theo title
                $possibleMatches = Properties::find()
                    ->andWhere(['like', 'title', $address])
                    ->all();

                $matchedProperty = null;

                foreach ($possibleMatches as $property) {
                    $matchCount = 0;

                    // So sánh từng phần địa chỉ đã normalize
                    $fields = ['house_number', 'street_name'];
                    foreach ($fields as $field) {
                        $propVal = $this->normalizeAddress($property->$field);
                        $listVal = $this->normalizeAddress($listing->$field);

                        if ($this->isSimilar($propVal, $listVal)) {
                            $matchCount++;
                        }
                    }

                    // Nếu >= 3/4 field giống nhau → coi như trùng
                    if ($matchCount >= 2) {
                        $matchedProperty = $property;
                        break;
                    }
                }

                if ($matchedProperty) {
                    $phones = [
                        $listing->phone1,
                        $listing->phone2,
                        $listing->phone3,
                        $listing->phone4,
                        $listing->phone5,
                        $listing->phone6
                    ];

                    foreach ($phones as $phone) {
                        if (!empty($phone)) {
                            $existContact = OwnerContacts::find()
                                ->where([
                                    'property_id' => $matchedProperty->property_id,
                                    'phone_number' => $phone
                                ])
                                ->one();

                            if (!$existContact) {
                                $contact = new OwnerContacts();
                                $contact->property_id = $matchedProperty->property_id;
                                $contact->contact_name = 'Không xác định';
                                $contact->phone_number = $phone;
                                $contact->role_id = 0;
                                $contact->gender_id = 0;
                                $contact->save(false);
                                echo "📞 Thêm số {$phone} vào property ID {$matchedProperty->property_id}\n";
                            } else {
                                echo "⚠️ Số {$phone} đã tồn tại trong property ID {$matchedProperty->property_id}\n";
                            }
                        }
                    }

                    $skip++;
                    echo "⏩ Địa chỉ trùng: {$address}\n";
                    continue;
                } else {
                    $property = new Properties();
                    $property->user_id = 1;
                    $property->listing_types_id = $listing->listing_types_id == "Bán" ? 1 : 2;
                    $property->house_number = $listing->house_number;
                    $property->street_name = $listing->street_name;
                    $property->ward_commune = $listing->ward_commune;
                    $property->district_county = $listing->district_county;
                    $property->city = $listing->city;
                    $property->price = $listing->price;
                    $property->final_price = $listing->final_price;
                    $property->area_total = $listing->area_total;
                    $property->area_width = $listing->area_width;
                    $property->area_length = $listing->area_length;
                    
                    $property->num_floors = $listing->num_floors;

                    $property->location_type_id = $this->getLocationTypes($listing->location_type_id);
                    $property->property_type_id = $this->getPropertyTypes($listing->property_type_id);
                    $property->land_type_id = $this->getLandType($listing->land_type_id);

                    $property->transaction_description = $listing->transaction_description;
                    $property->asset_type_id = 1;
                    $property->transaction_status_id = 1;
                    $property->has_rental_contract = 1;
                    $property->is_active = 1;
                    $property->status_review = 1;
                    $property->created_at = time();
                    $property->updated_at = time();
                    $property->title = "Số ". $property->house_number . " ". $property->street_name . ", Phường ". $property->ward_commune . ", ". $property->district_county . ", TP.HCM"; ;

                    if ($property->save(false)) {
                        
                        $count++;
                        echo "✅ Thêm mới property: {$address}\n";

                        if (!empty($listing->rent_price)) {
                            $rentPrice = $this->normalizePriceToNumber($listing->rent_price);
                            if ($rentPrice > 0) {
                                $this->createRentalContract($property->property_id, $rentPrice);
                            }
                        }

                        // Thêm OwnerContacts
                        $phones = [
                            $listing->phone1,
                            $listing->phone2,
                            $listing->phone3,
                            $listing->phone4,
                            $listing->phone5,
                            $listing->phone6
                        ];

                        foreach ($phones as $phone) {
                            if (!empty($phone)) {
                                $existContact = OwnerContacts::find()
                                    ->where([
                                        'property_id' => $property->property_id,
                                        'phone_number' => $phone
                                    ])
                                    ->one();
    
                                if (!$existContact) {
                                    $contact = new OwnerContacts();
                                    $contact->property_id = $property->property_id;
                                    $contact->contact_name = 'Không xác định';
                                    $contact->phone_number = $phone;
                                    $contact->role_id = 0;
                                    $contact->gender_id = 0;
                                    $contact->save(false);
                                    echo "📞 Thêm số {$phone} vào property ID {$property->property_id}\n";
                                } else {
                                    echo "⚠️ Số {$phone} đã tồn tại trong property ID {$property->property_id}\n";
                                }
                            }
                        }
                    } else {
                        echo "❌ Lỗi lưu Listing ID {$listing->id}\n";
                    }
                }
            }
        }

        echo "\n🎯 Tổng kết:\n";
        echo " - Đã thêm mới: {$count}\n";
        echo " - Bỏ qua trùng: {$skip}\n";
    }


    /**
     * Tạo hoặc cập nhật hợp đồng thuê tương ứng cho bất động sản
     */
    private function createRentalContract($propertyId, $rentPrice)
    {
        $contract = \common\models\RentalContracts::findOne(['property_id' => $propertyId]);
        if (!$contract) {
            $contract = new \common\models\RentalContracts();
            $contract->property_id = $propertyId;
        }

        $contract->rent_price = $rentPrice;
        $contract->currency_id = 1; // VND
        $contract->lease_term = null; // bạn có thể map nếu có
        $contract->lease_term_unit = \common\models\RentalContracts::LEASE_TERM_UNIT_MONTH;
        $contract->price_time_unit = \common\models\RentalContracts::PRICE_TIME_UNIT_PER_MONTH;
        $contract->expiry_date = null;

        if ($contract->save(false)) {
            echo "💰 Đã thêm/updated RentalContract cho property #{$propertyId} với giá thuê: {$rentPrice}\n";
        } else {
            echo "⚠️ Lỗi khi lưu hợp đồng thuê cho property #{$propertyId}\n";
        }
    }


    private function getLocationTypes($type_name)
    {
        if (empty($type_name)) {
            return 6;
        }
        return LocationTypes::find()
        ->select('location_type_id')
        ->where(['like', 'LOWER(type_name)', mb_strtolower(trim($type_name), 'UTF-8')])
        ->scalar();
    }

    private function getPropertyTypes($type_name)
    {
        if (empty($type_name)) {
            return 27;
        }
        return PropertyTypes::find()
        ->select('property_type_id')
        ->where(['like', 'LOWER(type_name)', mb_strtolower(trim($type_name), 'UTF-8')])
        ->scalar();
    }

    private function getLandType($type_name)
    {
        if (empty($type_name)) {
            return 0;
        }
        return LandType::find()
        ->select('id')
        ->where(['like', 'LOWER(name)', mb_strtolower(trim($type_name), 'UTF-8')])
        ->scalar();
    }

    /**
     * Chuẩn hóa chuỗi địa chỉ
     */
    private function normalizeAddress(...$parts)
    {
        $address = implode(' ', array_filter($parts));
        $address = mb_strtolower($address, 'UTF-8');
        $address = preg_replace('/\s+/', ' ', trim($address));
        $address = str_replace(['số ', 'so ', ',', '.', ';', '-'], '', $address);
        return $address;
    }

    private function normalizePriceToNumber($value)
    {
        if (empty($value)) {
            return 0;
        }
    
        // Chuẩn hóa chuỗi
        $value = trim(mb_strtolower($value, 'UTF-8'));
        $value = str_replace(',', '.', $value); // đổi dấu phẩy sang dấu chấm
        $value = preg_replace('/\s+/', ' ', $value); // loại bỏ khoảng trắng dư
    
        // Lấy phần số
        preg_match('/[\d\.]+/', $value, $matches);
        $number = isset($matches[0]) ? (float)$matches[0] : 0;
    
        // Nhân theo đơn vị
        if (strpos($value, 'tỷ') !== false || strpos($value, 'ty') !== false) {
            $number *= 1000000000; // tỷ
        } elseif (strpos($value, 'triệu') !== false || strpos($value, 'trieu') !== false) {
            $number *= 1000000; // triệu
        } elseif (strpos($value, 'nghìn') !== false || strpos($value, 'ngan') !== false || strpos($value, 'k') !== false) {
            $number *= 1000; // nghìn
        }
    
        return (int) round($number);
    }


    /**
     * So sánh chuỗi gần đúng
     */
    private function isSimilar($a, $b)
    {
        if ($a === '' || $b === '') {
            return false;
        }

        // Nếu chuỗi con nằm trong chuỗi cha
        if (mb_strpos($a, $b) !== false || mb_strpos($b, $a) !== false) {
            return true;
        }

        // Tính độ tương đồng bằng similar_text
        similar_text($a, $b, $percent);
        return $percent >= 70; // 70% độ tương đồng coi như gần đúng
    }
}
