<?php

namespace console\controllers;

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

    public function actionDeleteDuplicate()
    {
        $transaction = Properties::getDb()->beginTransaction();
        try {
            $properties = Properties::find()
            ->where(['title' => null])
            ->andWhere(['!=', 'tmp_id', ''])
            ->all();

            foreach ($properties as $property) {
                $duplicate = Properties::find()
                    ->where([
                        'house_number' => $property->house_number,
                        'street_name' =>  $property->street_name,
                        'ward_commune' =>  $property->ward_commune,
                        'tmp_id' => null,
                    ])
                    ->one();
                if ($duplicate) {
                    $duplicateId = $property->primaryKey;
                    if ($property->delete()) {
                        echo "🗑 Đã xóa bản ghi duplicate ID {$duplicateId} (tmp_id IS NULL)\n";
                    } else {
                        echo "❌ Lỗi khi xóa bản ghi duplicate ID {$duplicateId}\n";
                    }
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
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
