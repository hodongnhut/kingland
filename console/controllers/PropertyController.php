<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\Properties;
use common\models\NewWardMapping;

class PropertyController extends Controller
{
    public function actionUpdateNewDistrict()
    {
        $query = Properties::find()->where(['new_district' => null]);
        $batchSize = 500;
        $total = $query->count();
        $updated = 0;

        echo "Tổng cộng $total bất động sản cần cập nhật...\n";

        for ($offset = 0; $offset < $total; $offset += $batchSize) {
            $properties = $query->offset($offset)->limit($batchSize)->all();

            foreach ($properties as $property) {
                $province = $property->city;
                $district = $property->district_county;
                $ward     = $property->ward_commune;

                $newDistrict = $this->findNewDistrict($province, $district, $ward);

                if ($newDistrict) {
                    $property->new_district = $newDistrict;
                    if ($property->save(false)) {
                        $updated++;
                        echo "✅ Updated property ID {$property->property_id} => $newDistrict\n";
                    } else {
                        echo "❌ Failed to update property ID {$property->property_id}\n";
                    }
                }
            }

            echo "👉 Đã xử lý từ $offset đến " . ($offset + $batchSize) . "\n";
        }

        echo "🎉 Hoàn tất. Đã cập nhật $updated bất động sản.\n";
    }

    private function findNewDistrict($province, $district, $ward)
    {
        if (empty($district) || empty($ward)) {
            return null;
        }
        
        $district = $this->normalizeDistrict($district);
        $ward     = $this->normalizeWard($ward);

        $districtLike = "%{$district}%";
        $wardLike     = "%{$ward}%";
        $result = NewWardMapping::find()
            ->where(['like', 'Old_Districts', $districtLike, false])
            ->andWhere(['like', 'Old_Names', $wardLike, false])
            ->one();

        if (!empty($result)) {
            return $result->New_Type . ' ' . $result->New_Name;
        }

        return null;
    }

    private function normalizeWard($ward)
    {
        $ward = trim($ward);

        if (preg_match('/^p\s*(\d{1,2})$/i', $ward, $matches)) {
            return 'Phường ' . $matches[1];
        }

        if (preg_match('/^\d{1,2}$/', $ward)) {
            return 'Phường ' . $ward;
        }

        if (preg_match('/^phường/i', $ward)) {
            return $ward;
        }

        return $ward;
    }

    private function normalizeDistrict($district)
    {
        $district = trim($district);

        // Nếu bắt đầu bằng 'Q' hoặc 'q' và theo sau là số, thay bằng 'Quận'
        if (preg_match('/^q\s*(\d{1,2})$/i', $district, $matches)) {
            return 'Quận ' . $matches[1];
        }

        // Nếu chỉ là số (vd: '3', '10')
        if (preg_match('/^\d{1,2}$/', $district)) {
            return 'Quận ' . $district;
        }

        // Nếu đã bắt đầu bằng "Quận", giữ nguyên
        if (preg_match('/^quận/i', $district)) {
            return $district;
        }

        // Các trường hợp khác: huyện, thị xã... giữ nguyên
        return $district;
    }

}
