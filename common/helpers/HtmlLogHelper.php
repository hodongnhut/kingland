<?php
namespace common\helpers;

use Yii;

use common\models\PropertyUpdateLog;

class HtmlLogHelper
{
    public static function renderHtmlLog($event)
    {
        $model = $event->sender;
        $logModel = PropertyUpdateLog::find()
            ->where(['property_id' => $model->property_id])
            ->one();
        if (!empty($logModel)) {
            return self::renderHistoryEntry($model);

        } else {
            return self::renderHistoryEntryMain($model);
        }
    }

    public static function renderHistoryEntryMain($model) {
        $createdAt = date('d-m-Y', strtotime($model->created_at));
        $timeAgo = Yii::$app->formatter->asRelativeTime($model->created_at);
        $createdBy = $model->created_by ?? 'Hệ thống';

        $note = 'Nhà <b>' . self::formatPriceUnit($model->price) . '</b> có diện tích ' . 
        self::formatNumber($model->area_width) . 'm × ' . self::formatNumber($model->area_length) . 'm';

        // Lợi thế
        if (!empty($model->propertyAdvantages)) {
            $note .= ', ';
            $advantages = array_map(function($item) {
                return $item->advantage->name;
            }, $model->propertyAdvantages);
            $note .= implode(', ', $advantages);
        }

        // Bất lợi
        if (!empty($model->propertyDisadvantages)) {
            $note .= ', ';
            $disadvantages = array_map(function($item) {
                return $item->disadvantage->disadvantage_name;
            }, $model->propertyDisadvantages);
            $note .= implode(', ', $disadvantages);
        }

        $contactHtml = '';
        if (!empty($model->ownerContacts)) {
            foreach ($model->ownerContacts as $contact) {
                $contactHtml .= '
                    <div class="icon-text" style="margin-top: 5px;">
                        <i class="fas fa-user-alt"></i> ' . htmlspecialchars($contact->contact_name ?? 'N/A') . ' 
                        <span style="color: #e74c3c;">****,****.'.substr($contact->phone_number, -3).'</span> 
                        <span style="font-weight: bold;">' . htmlspecialchars($contact->contact_role ?? 'Chủ nhà') . '</span>
                    </div>';
            }
        }
        $ward = '';
        if (!preg_match('/^(phường|xã)/i', $model->ward_commune)) {
            $ward = 'Phường ' . $model->ward_commune;
        }

        $html = '';
        $html =  $html .= '<div class="history-entry-main">
                <div class="entry-header">
                    <i class="fas fa-user-alt"></i> 
                    '. $model->user->username.'
                    <span>' . $timeAgo . ' (' . $createdAt . ')</span>
                    <span>' . htmlspecialchars($createdBy) . ' <i class="info-icon">ⓘ</i></span>
                </div>

                <div class="tin-goc-badge">
                    TIN GỐC được đăng đầu tiên
                </div>

                <div class="copy-info" id="copyText' . $model->property_id . '">
                    ' .  $note . ' <i class="far fa-copy mr-1"></i>
                </div>

                <div class="contact-info-block">
                    <div class="icon-text">
                        <i class="fas fa-id-card-alt"></i> Thêm Thông Tin Liên Hệ
                    </div>
                    '. $contactHtml .'
                </div>

                <div class="position-badge">
                    ' . htmlspecialchars($model->locationTypes->type_name  ?? 'Vị Trí Mặt Tiền') . '
                </div>

                <div class="entry-content">
                    Set Loại sản phẩm: ' . htmlspecialchars($model->assetType->type_name ?? 'Bất động sản khác') . '
                </div>

                <div class="location-map-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/3060/3060411.png" alt="Map Pin">
                    ' . htmlspecialchars($ward  ?? 'Chưa khai báo') . '
                </div>

                <div class="price-details-grid">
                    <div class="price-details-item">
                        Mức Giá<br>
                        <span class="value" style="color: #e74c3c;">' . self::formatPriceUnit($model->price ?? 'N/A') . '</span> 
                        <span class="arrow-up">↑</span>
                    </div>
                    <div class="price-details-item">
                        Giá/m2<br>
                        <span class="value" style="color: #3498db;">' . self::pricePerSquareMeter($model). '</span>
                    </div>
                    <div class="price-details-item">
                        Diện Tích<br>
                        <span class="value" style="color: #3498db;">' . htmlspecialchars($model->area_total   ?? '-') . '</span>
                    </div>
                    <div class="price-details-item">
                        Rộng<br>
                        <span class="value" style="color: #3498db;">' . htmlspecialchars($model->area_width ?? '-') . '</span>
                    </div>
                    <div class="price-details-item">
                        Dài<br>
                        <span class="value" style="color: #3498db;">' . htmlspecialchars($model->area_length ?? '-') . '</span>
                    </div>
                </div>
            </div>';
        return $html;
    }

    public static function pricePerSquareMeter($model) {
        $totalPrice = $model->price; 
        $totalArea = $model->area_total;
        $pricePerSqM_Text = '';

        if ($totalArea > 0 && $totalPrice > 0) {
            $pricePerSqM_VND = $totalPrice / $totalArea;
            $pricePerSqM_Text = self::formatPriceUnit($pricePerSqM_VND);
        }
        return $pricePerSqM_Text;
    }

    public static function renderHistoryEntry($model) {
        $createdAt = date('d-m-Y', strtotime($model->created_at));
        $timeAgo = Yii::$app->formatter->asRelativeTime($model->created_at);
        $createdBy = $model->created_by ?? 'Hệ thống';
    
        $html = '
        <div class="history-entry">
            <div class="entry-header">
                <span>' . htmlspecialchars($timeAgo) . ' (' . htmlspecialchars($createdAt) . ')</span>
                <span>' . htmlspecialchars($createdBy) . ' <i class="info-icon">ⓘ</i></span>
            </div>
            <div class="entry-content">
                Thêm Thông Tin Liên Hệ
            </div>
            <div class="property-details-block">
                <div><span>Giá/m2:</span> ' . self::pricePerSquareMeter($model) . '</div>
                <div><span>Diện tích:</span> ' . $model->area_total . ' m2</div>
                <div><span>Rộng:</span> ' . $model->area_width . ' m</div>
                <div><span>Dài:</span> ' . $model->area_length . ' m</div>
            </div>
            <br>
            <button class="entry-action-button">Bấm xác minh</button>
        </div>';
    
        return $html;
    }
    


    public static function formatNumber($number) {
        if ($number === null) {
            return null;
        }
        if ($number == (int)$number) {
            return (int)$number;
        }
        
        return (float)$number;
    }

    public static function formatPriceUnit($number) {
        if (!is_numeric($number) || $number <= 0) {
            return 'Thỏa thuận';
        }
    
        $billion = 1000000000;
        $million = 1000000;
    
        if ($number >= $billion) {
            $result = $number / $billion;
            $formatted_result = rtrim(rtrim(number_format($result, 1, '.', ''), '0'), '.');
            return $formatted_result . ' Tỷ';
        }
    
        if ($number >= $million) {
            $result = $number / $million;
            $formatted_result = round($result);
            return $formatted_result . ' Triệu';
        }
        
        return number_format($number) . ' VNĐ';
    }
}