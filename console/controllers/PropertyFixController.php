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
