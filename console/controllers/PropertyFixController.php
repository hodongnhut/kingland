<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Properties;

class PropertyFixController extends Controller
{
    /**
     * Fix city, district, ward, street_name from title.
     * Run: php yii property-fix/fix-address
     */
    public function actionFixAddress()
    {
        // Chỉ chọn những bản ghi cần cập nhật
        $properties = Properties::find()
            ->andWhere(['not', ['title' => null]])
            ->all();

        foreach ($properties as $property) {
            $title = $property->title;

            // Tách chuỗi theo dấu phẩy
            $parts = array_map('trim', explode(',', $title));

            // Nếu ít nhất có 4 phần thì mới tiếp tục
            if (count($parts) >= 4) {
                $property->street_name = $parts[0];          // "Số 8/24 Số 38"
                $property->ward_commune = $parts[1];         // "Hiệp Bình Chánh"
                $property->district_county = $parts[2];      // "Thủ Đức"
                $property->city = $parts[3];                 // "TP.HCM"

                if ($property->save(false)) {
                    echo "✔ Cập nhật thành công ID: {$property->property_id}\n";
                } else {
                    echo "✖ Lỗi khi lưu ID: {$property->property_id}\n";
                }
            } else {
                echo "⚠ Không đủ dữ liệu để tách title: \"{$title}\"\n";
            }
        }

        echo "✅ Hoàn tất cập nhật địa chỉ\n";
    }

    public function actionFixStreet() {

        // Giả định Properties là model hợp lệ
        $properties = Properties::find()
            // Chỉ lấy những thuộc tính cần thiết
            ->all();
    
        echo "Bắt đầu cập nhật tên đường cho " . count($properties) . " bất động sản.\n";
        echo "--------------------------------------------------------\n";
    
        foreach ($properties as $property) {
            
            $originalStreetName = $property->street_name;
            $newStreetName = '';
            $source = 'street_name'; // Theo dõi nguồn dữ liệu
    
            // 1. KIỂM TRA street_name GỐC
            if ($originalStreetName === null || trim($originalStreetName) === '') {
                // Trường hợp street_name là NULL/rỗng: Thử lấy từ title
                
                if (!empty($property->title)) {
                    $source = 'title';
                    
                    // Tách title theo dấu phẩy và làm sạch khoảng trắng
                    $parts = array_map('trim', explode(',', $property->title));
                    
                    // Giả định tên Đường nằm ở vị trí thứ hai (index 1)
                    if (isset($parts[1])) {
                        $streetCandidate = $parts[1];
                        // Áp dụng hàm làm sạch tên đường lên ứng viên này
                        $newStreetName = $this->extractFlexibleStreetName($streetCandidate);
                    } else {
                        echo "ℹ Bỏ qua ID: {$property->property_id} - street_name NULL và title không đủ phần.\n";
                        continue; // Bỏ qua nếu title không đủ phần
                    }
                } else {
                    echo "ℹ Bỏ qua ID: {$property->property_id} - street_name và title đều rỗng/NULL.\n";
                    continue; // Bỏ qua nếu cả hai đều rỗng/NULL
                }
    
            } else {
                // Trường hợp street_name CÓ giá trị: Tiến hành làm sạch như bình thường
                $newStreetName = $this->extractFlexibleStreetName($originalStreetName);
            }
    
            // 2. So sánh và Cập nhật
            // So sánh với giá trị GỐC trong model (chứ không phải $originalStreetName nếu nó là NULL)
            if ($property->street_name === $newStreetName) {
                echo "ℹ Bỏ qua ID: {$property->property_id} - Không có thay đổi.\n";
                continue;
            }
    
            // 3. Tiến hành cập nhật trực tiếp vào database
            $isUpdated = $property->updateAttributes(['street_name' => $newStreetName]); 
            
            if ($isUpdated !== false) { 
                echo "✔ Cập nhật thành công ID: {$property->property_id} (Nguồn: {$source}) -> Tên mới: \"{$newStreetName}\"\n";
            } else {
                echo "✖ Lỗi khi cập nhật ID: {$property->property_id}\n";
            }
        }
    
        echo "--------------------------------------------------------\n";
        echo "✅ Hoàn tất cập nhật địa chỉ\n";
    }

    private function extractFlexibleStreetName($address) {
    
        // 1. An toàn: Xử lý trường hợp $address là null hoặc không phải chuỗi
        if (!is_string($address) || $address === null || trim($address) === '') {
            return '';
        }
        
        // Lưu lại giá trị gốc (đã cắt khoảng trắng)
        $originalAddress = trim($address);
        
        // 2. Biểu thức chính quy: Loại bỏ số nhà và tiền tố "Số"
        // (Bắt đầu từ "Số..." HOẶC chỉ số nhà/hẻm...)
        $pattern = '/^(?i)\s*Số\s*([\d\-\/\.\s]+([A-Za-z](?![A-Za-z])[-\/\d]*)*)\s+|^\s*([\d\-\/\.\s]+([A-Za-z](?![A-Za-z])[-\/\d]*)*)\s+|^\s*(?i)Số\s*([\d\-\/\.]+([A-Za-z](?![A-Za-z])[-\/\d]*)*)(?![\p{L}\s])/u';
    
        
        // Áp dụng regex để loại bỏ phần địa chỉ nhà
        $streetName = preg_replace($pattern, '', $originalAddress);
        
        // Cắt khoảng trắng thừa
        $result = trim($streetName);
        
        // 3. LOGIC BỔ SUNG: Xử lý trường hợp chỉ còn lại số hoặc chuỗi rỗng
        
        // Regex để kiểm tra xem chuỗi CHỈ chứa chữ số và dấu chấm/gạch chéo/gạch ngang/khoảng trắng
        $isOnlyNumberLike = preg_match('/^[\d\s\/\-\.]+$/u', $originalAddress);
        
        if ($result === '') {
            // Trường hợp 3a: Kết quả rỗng => Giá trị gốc CHỈ là số nhà/hẻm. 
            // Ta giữ lại giá trị gốc vì có thể đó là tên đường ("123")
            if ($isOnlyNumberLike) {
                 $result = $originalAddress; 
            } else {
                 // Trường hợp $originalAddress không phải chỉ là số và bị xóa hết (rất hiếm).
                 return '';
            }
        }
    
        // 4. **LOGIC THÊM PREFIX THEO YÊU CẦU:** // Chỉ thêm "Đường" nếu chuỗi kết quả (sau bước 3) chỉ bao gồm chữ số.
        // Dùng is_numeric() hoặc kiểm tra regex đơn giản hơn.
        
        // Kiểm tra xem chuỗi $result CÓ PHẢI là chuỗi chỉ chứa SỐ không (bao gồm số thập phân)
        if (is_numeric($result)) {
            // Hoặc kiểm tra regex nghiêm ngặt hơn nếu bạn chỉ muốn số nguyên: preg_match('/^\d+$/', $result)
            
            // Thêm prefix "Đường"
            return 'Đường ' . $result;
        }
        
        // 5. Trả về kết quả đã làm sạch mà không thêm prefix "Đường" nếu nó đã là tên đường đầy đủ
        return $result;
    }



    public function actionFixHouseNumber()
    {
        // Giả định Properties là model hợp lệ
        $properties = Properties::find()->all();
    
        echo "Bắt đầu cập nhật số nhà cho " . count($properties) . " bất động sản.\n";
        echo "--------------------------------------------------------\n";
    
        foreach ($properties as $property) {
            $originalHouseNumber = $property->house_number;
            $newHouseNumber = '';
            $source = 'house_number'; // Theo dõi nguồn dữ liệu
    
            // 1. KIỂM TRA house_number GỐC
            if ($originalHouseNumber === null || trim($originalHouseNumber) === '') {
                // Trường hợp house_number là NULL/rỗng: Thử lấy từ title
                if (!empty($property->title)) {
                    $source = 'title';
                    // Tách title theo dấu phẩy và làm sạch khoảng trắng
                    $parts = array_map('trim', explode(',', $property->title));
                    // Giả định số nhà nằm ở vị trí thứ hai (index 1)
                    if (isset($parts[0])) {
                        $addressCandidate = $parts[0];
                        // Áp dụng hàm lấy số nhà
                        $newHouseNumber = $this->extractHouseNumber($addressCandidate);
                    } else {
                        echo "ℹ Bỏ qua ID: {$property->property_id} - house_number NULL và title không đủ phần.\n";
                        continue; // Bỏ qua nếu title không đủ phần
                    }
                } else {
                    echo "ℹ Bỏ qua ID: {$property->property_id} - house_number và title đều rỗng/NULL.\n";
                    continue; // Bỏ qua nếu cả hai đều rỗng/NULL
                }
            } else {
                // Trường hợp house_number CÓ giá trị: Tiến hành lấy số nhà
                $newHouseNumber = $this->extractHouseNumber($originalHouseNumber);
            }
    
            // 2. So sánh và Cập nhật
            if ($newHouseNumber === '' || $property->house_number === $newHouseNumber) {
                echo "ℹ Bỏ qua ID: {$property->property_id} - Không có thay đổi hoặc số nhà rỗng.\n";
                continue;
            }
    
            // 3. Tiến hành cập nhật trực tiếp vào database
            $isUpdated = $property->updateAttributes(['house_number' => $newHouseNumber]); 
            
            if ($isUpdated !== false) { 
                echo "✔ Cập nhật thành công ID: {$property->property_id} (Nguồn: {$source}) -> Số nhà mới: \"{$newHouseNumber}\"\n";
            } else {
                echo "✖ Lỗi khi cập nhật ID: {$property->property_id}\n";
            }
        }
    
        echo "--------------------------------------------------------\n";
        echo "✅ Hoàn tất cập nhật số nhà\n";
    }

    private function extractHouseNumber($address)
    {
        if (!is_string($address) || $address === null || trim($address) === '') {
            return '';
        }
        // Regex kết hợp: Khớp với DẠNG 1, DẠNG 2, hoặc DẠNG 3 để lấy số nhà
        // Dạng 1 (có "Số" + khoảng trắng): Bắt đầu (^), tùy chọn khoảng trắng (\s*), "Số" (case-insensitive: (?i)), 
        //                                  số nhà/hẻm (chữ số, -, /, ., khoảng trắng, tùy chọn chữ cái: ([\d\-\/\.\s]+([A-Za-z][-\/\d]*)*))\s+.
        // Dạng 2 (không "Số" + khoảng trắng): Bắt đầu (^), tùy chọn khoảng trắng (\s*), số nhà/hẻm ([\d\-\/\.\s]+([A-Za-z][-\/\d]*)*)\s+.
        // Dạng 3 (có hoặc không "Số" + không khoảng trắng): Bắt đầu (^), tùy chọn khoảng trắng (\s*), tùy chọn "Số" ((?i)Số\s*)?, 
        //                                                  số nhà/hẻm ([\d\-\/\.]+([A-Za-z][-\/\d]*)*).
        $pattern = '/^(?i)\s*Số\s*([\d\-\/\.\s]+([A-Za-z](?![A-Za-z])[-\/\d]*)*)\s+|^\s*([\d\-\/\.\s]+([A-Za-z](?![A-Za-z])[-\/\d]*)*)\s+|^\s*(?i)Số\s*([\d\-\/\.]+([A-Za-z](?![A-Za-z])[-\/\d]*)*)/u';
    
        // Tìm kiếm và lấy nhóm khớp (số nhà)
        if (preg_match($pattern, $address, $matches)) {
            // Kiểm tra các nhóm khớp từ các dạng
            return trim($matches[1] ?: ($matches[3] ?: ($matches[5] ?: '')));
        }
        
        // Nếu không khớp, trả về chuỗi rỗng
        return '';
    }

    /**
     * Fix city, district, ward, street_name from title.
     * Run: php yii property-fix/fix-address
     */
    public function actionFixAddressTitle()
    {
        // Chỉ chọn những bản ghi cần cập nhật
        $properties = Properties::find()
        ->where(['title' => null])
        ->andWhere(['!=', 'tmp_id', ''])
        ->all();

        foreach ($properties as $property) {
            $title = null;
            $title = "Số ". $property->house_number . " ". $property->street_name . ", Phường ". $property->ward_commune . ", ". $property->district_county . ", TP.HCM"; 
            $property->title = $title;
            $property->updateAttributes([
                'title' => $title,
            ]);
            echo "✔ Cập nhật thành công title: \"{$title}\"\n";
        }

      
    }

   /**
     * Delete duplicate records based on house_number, normalized street_name, ward_commune, and district_county.
     * Run: php yii property-fix/delete-duplicate
     */
    public function actionDeleteDuplicate()
    {
        $transaction = Properties::getDb()->beginTransaction();
        try {
            // Step 1: Identify duplicates by grouping on house_number, normalized street_name, ward_commune, and district_county
            $duplicates = Properties::find()
                ->select([
                    'house_number',
                    'TRIM(REGEXP_REPLACE(LOWER(street_name), CONCAT(\'^số\s*\\d+\s*\', LOWER(house_number), \'\s*\'), \'\')) AS normalized_street_name',
                    'ward_commune',
                    'district_county',
                    'COUNT(*) as cnt',
                    'MIN(property_id) as min_property_id'
                ])
                ->where(['not', ['house_number' => null]])
                ->andWhere(['not', ['house_number' => '']])
                ->andWhere(['not', ['street_name' => null]])
                ->andWhere(['not', ['street_name' => '']])
                ->andWhere(['not', ['ward_commune' => null]])
                ->andWhere(['not', ['ward_commune' => '']])
                ->andWhere(['not', ['district_county' => null]])
                ->andWhere(['not', ['district_county' => '']])
                ->groupBy([
                    'house_number',
                    'TRIM(REGEXP_REPLACE(LOWER(street_name), CONCAT(\'^số\s*\\d+\s*\', LOWER(house_number), \'\s*\'), \'\'))',
                    'ward_commune',
                    'district_county'
                ])
                ->having(['>', 'cnt', 1])
                ->asArray()
                ->all();

            $duplicateIds = [];
            foreach ($duplicates as $duplicate) {
                $houseNumber = $duplicate['house_number'];
                $normalizedStreetName = $duplicate['normalized_street_name'];
                $wardCommune = $duplicate['ward_commune'];
                $districtCounty = $duplicate['district_county'];
                $minPropertyId = $duplicate['min_property_id'];

                if (empty($normalizedStreetName)) {
                    echo "⚠ Bỏ qua house_number: {$houseNumber}, ward_commune: {$wardCommune}, district_county: {$districtCounty}, normalized_street_name rỗng\n";
                    continue;
                }

                // Find all records for this house_number, normalized street_name, ward_commune, and district_county, excluding the one with min_property_id
                $duplicateRecords = Properties::find()
                    ->where(['house_number' => $houseNumber])
                    ->andWhere(['like', 'LOWER(street_name)', $normalizedStreetName])
                    ->andWhere(['ward_commune' => $wardCommune])
                    ->andWhere(['district_county' => $districtCounty])
                    ->andWhere(['not', ['property_id' => $minPropertyId]])
                    ->all();

                foreach ($duplicateRecords as $record) {
                    $duplicateIds[] = $record->property_id;
                    echo "🗑 Tìm thấy bản ghi trùng lặp ID {$record->property_id} (house_number: {$houseNumber}, street_name: {$record->street_name}, ward_commune: {$wardCommune}, district_county: {$districtCounty})\n";
                    Yii::info("Tìm thấy trùng lặp ID {$record->property_id}: house_number={$houseNumber}, street_name={$record->street_name}, ward_commune={$wardCommune}, district_county={$districtCounty}", __METHOD__);
                }
            }

            // Step 2: Delete duplicates in bulk
            if (!empty($duplicateIds)) {
                $deletedCount = Properties::deleteAll(['property_id' => $duplicateIds]);
                echo "🗑 Đã xóa {$deletedCount} bản ghi trùng lặp\n";
                Yii::info("Đã xóa {$deletedCount} bản ghi trùng lặp", __METHOD__);
            } else {
                echo "ℹ Không tìm thấy bản ghi trùng lặp\n";
            }

            $transaction->commit();
            echo "✅ Hoàn tất xóa bản ghi trùng lặp\n";
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Lỗi xóa trùng lặp: " . $e->getMessage());
            echo "❌ Lỗi: " . $e->getMessage() . "\n";
        }
    }

    public function actionFixDistrictNames()
    {
        $properties = Properties::find()
            ->where(['between', 'district_county', 1, 12])
            ->all();

        foreach ($properties as $property) {
            $districtNumber = (int) $property->district_county;

            if ($districtNumber >= 1 && $districtNumber <= 12) {
                $newDistrictName = 'Quận ' . $districtNumber;
                $property->district_county = $newDistrictName;
                $property->updateAttributes(attributes: [
                    'district_county' => $newDistrictName,
                ]);
                echo "✔ ID {$property->property_id}: Đã cập nhật thành {$newDistrictName}\n";
            }
        }

        echo "✅ Hoàn tất cập nhật district_county.\n";
    }

}
