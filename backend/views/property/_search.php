<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// Ghi chú: Để chống "nháy" giao diện, hãy thêm đoạn CSS này vào thẻ <head> trong file layout chính của bạn
// <style>
//     [x-cloak] { display: none !important; }
// </style>

$searchParams = Yii::$app->request->get('PropertiesSearch', []);

$advancedFields = [
    'update_by',
    'asset_type_id',
    'advantage_ids',
    'disadvantage_ids',
    'direction_ids',
    'num_floors_from',
    'num_floors_to',
    'num_bedrooms_from',
    'num_bedrooms_to',
    'date_from',
    'date_to'
];

$isAdvancedPanelOpen = false;
foreach ($advancedFields as $field) {
    // Nếu tìm thấy bất kỳ trường nào có giá trị, đặt biến là true và dừng lại
    if (!empty($searchParams[$field])) {
        $isAdvancedPanelOpen = true;
        break;
    }
}

?>

<!-- NÂNG CẤP: Logic giữ trạng thái mở được chuyển vào x-init bên dưới -->
<div class="bg-white p-6 rounded-lg shadow-md mb-6"
     x-data="{ advancedSearchOpen: <?= $isAdvancedPanelOpen ? 'true' : 'false' ?> }"
>
    <?php $form = ActiveForm::begin([
        'action' => ['/property'],
        'method' => 'get',
        'options' => [
            'data-pjax' => true,
            'id' => 'property-search-form' // Thêm ID cho form
        ],
        'fieldConfig' => [
            'template' => '{input}',
            'inputOptions' => [
                'class' => 'form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 w-full',
            ],
        ],
    ]); ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-4">
        <div>
            <?= Html::textInput(
                'PropertiesSearch[keyword]',
                $searchParams['keyword'] ?? null,
                [
                    'class' => 'form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 w-full',
                    'placeholder' => 'Điện Thoại | Số Nhà | Đường Phố | Khu Vực '
                ]
            ) ?>
        </div>

        <?php
            $selectedListingTypeId = $searchParams['listing_types_id'] ?? null;
            echo Html::dropDownList(
                'PropertiesSearch[listing_types_id]',
                $selectedListingTypeId,
                ArrayHelper::map($listingTypes, 'id', 'name'),
                [
                    'prompt' => 'Loại Giao Dịch',
                    'class' => 'form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 w-full'
                ]
            );
        ?>

        <?php
    // Giữ nguyên đoạn PHP này
    $selectedLocationIds = [];
    $locationValue = $searchParams['location_type_id'] ?? [];
    if (!empty($locationValue) && is_string($locationValue)) {
        $selectedLocationIds = array_map('intval', explode(',', $locationValue));
    } elseif (is_array($locationValue)) {
        $selectedLocationIds = $locationValue;
    }
?>

<div x-data="{ initialized: false }">

    <button x-show="!initialized" @click="initialized = true" type="button" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
         <span>
            <?php if (empty($selectedLocationIds)): ?>
                <span class="text-gray-800">Chọn Vị Trí</span>
            <?php else: ?>
                <span class="text-gray-700">Đã chọn: <?= count($selectedLocationIds) ?> vị trí</span>
            <?php endif; ?>
        </span>
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
    </button>

    <template x-if="initialized">
        <div x-data="{
                open: false,
                selected: <?php echo json_encode($selectedLocationIds); ?>,
                toggle(id) { if (this.selected.includes(id)) { this.selected = this.selected.filter(i => i !== id) } else { this.selected.push(id) } },
                clearAll() { this.selected = [] }
            }"
            @reset-form.window="selected = []"
            class="relative" x-cloak
            x-init="
                $watch('selected', val => { document.getElementById('location_type_hidden').value = val.join(','); });
                $nextTick(() => open = true);
            "
            @click.away="open = false"
         >
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span>
                    <template x-if="selected.length === 0"><span class="text-gray-800">Chọn Vị Trí</span></template>
                    <template x-if="selected.length > 0"><span class="text-gray-700" x-text="'Đã chọn: ' + selected.length + ' vị trí'"></span></template>
                </span>
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="open" x-transition class="absolute z-10 bg-white border border-gray-200 rounded-md shadow-lg w-full mt-2">
                <div x-show="selected.length > 0" class="border-b border-gray-200">
                    <button type="button" @click="clearAll(); open = false" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Xóa tất cả lựa chọn
                    </button>
                </div>
                <ul class="py-1 max-h-60 overflow-y-auto">
                    <?php foreach ($locationTypes as $location): ?>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                            <input type="checkbox" value="<?= $location->location_type_id; ?>" :checked="selected.includes(<?= $location->location_type_id; ?>)" @change="toggle(<?= $location->location_type_id; ?>)" class="mr-2 rounded" id="loc-<?= $location->location_type_id; ?>">
                            <label for="loc-<?= $location->location_type_id; ?>" class="flex-grow cursor-pointer"><?= Html::encode($location->type_name); ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            </div>
    </template>

    <input
        type="hidden"
        name="PropertiesSearch[location_type_id]"
        id="location_type_hidden"
        class="resettable-hidden-input"
        value="<?= implode(',', $selectedLocationIds) ?>"
    />
</div>

        <?php
    // Giữ nguyên đoạn PHP này
    $selectedIds = [];
    $inputValue = $searchParams['property_type_id'] ?? '';
    if (!empty($inputValue) && is_string($inputValue)) {
        $selectedIds = array_map('intval', explode(',', $inputValue));
    } elseif (is_array($inputValue)) {
        $selectedIds = $inputValue;
    }
?>

<div x-data="{ initialized: false }">

    <button x-show="!initialized" @click="initialized = true" type="button" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <span>
            <?php if (empty($selectedIds)): ?>
                <span class="text-gray-800">Chọn Loại Sản Phẩm</span>
            <?php else: ?>
                <span class="text-gray-700">Đã chọn: <?= count($selectedIds) ?> mục</span>
            <?php endif; ?>
        </span>
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
    </button>

    <template x-if="initialized">
        <div x-data="{
                open: false,
                selected: <?php echo json_encode($selectedIds); ?>,
                toggle(id) { if (this.selected.includes(id)) { this.selected = this.selected.filter(i => i !== id) } else { this.selected.push(id) } },
                clearAll() { this.selected = [] }
            }"
            @reset-form.window="selected = []"
            class="relative" x-cloak
            x-init="
                $watch('selected', val => { document.getElementById('property_type_hidden').value = val.join(','); });
                $nextTick(() => open = true);
            "
            @click.away="open = false"
        >
             <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span>
                    <template x-if="selected.length === 0"><span class="text-gray-800">Chọn Loại Sản Phẩm</span></template>
                    <template x-if="selected.length > 0"><span class="text-gray-700" x-text="'Đã chọn: ' + selected.length + ' mục'"></span></template>
                </span>
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="open" x-transition class="absolute z-10 bg-white border border-gray-200 rounded-md shadow-lg w-full mt-2">
                <div x-show="selected.length > 0" class="border-b border-gray-200">
                    <button type="button" @click="clearAll(); open = false" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Xóa tất cả lựa chọn
                    </button>
                </div>
                <ul class="py-1 max-h-60 overflow-y-auto">
                    <?php foreach ($propertyTypes as $type): ?>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                            <input type="checkbox" value="<?= $type->property_type_id; ?>" :checked="selected.includes(<?= $type->property_type_id; ?>)" @change="toggle(<?= $type->property_type_id; ?>)" class="mr-2 rounded" id="prop-<?= $type->property_type_id; ?>">
                            <label for="prop-<?= $type->property_type_id; ?>" class="flex-grow cursor-pointer"><?= Html::encode($type->type_name); ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            </div>
    </template>

    <input
    type="hidden"
    name="PropertiesSearch[property_type_id]"
    id="property_type_hidden"
    class="resettable-hidden-input" value="<?= implode(',', $selectedIds) ?>"
/>
</div>

        

        <div class="flex items-center space-x-2">
            <?= Html::textInput('PropertiesSearch[plot_number]', $searchParams['plot_number'] ?? null, ['placeholder' => 'Số Thửa', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
            <?= Html::textInput('PropertiesSearch[sheet_number]', $searchParams['sheet_number'] ?? null, ['placeholder' => 'Số Tờ', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
        </div>
        <div class="flex items-center space-x-2">
            <?= Html::textInput('PropertiesSearch[city]', $searchParams['city'] ?? null, ['placeholder' => 'Hồ Chí Minh', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
            <?= Html::textInput('PropertiesSearch[district_county]', $searchParams['district_county'] ?? null, ['placeholder' => 'Chọn Quận/Huyện', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
        </div>
        <div class="flex items-center space-x-2">
            <?= Html::textInput('PropertiesSearch[ward_commune]', $searchParams['ward_commune'] ?? null, ['placeholder' => 'Chọn Phường/Xã', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
            <?= Html::textInput('PropertiesSearch[street_name]', $searchParams['street_name'] ?? null, ['placeholder' => 'Chọn Đường Phố', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
        </div>
        <div class="flex items-center space-x-2">
            <?= Html::textInput('PropertiesSearch[area_width_from]', $searchParams['area_width_from'] ?? null, ['placeholder' => 'Rộng từ', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
            <span>đến</span>
            <?= Html::textInput('PropertiesSearch[area_width_to]', $searchParams['area_width_to'] ?? null, ['placeholder' => 'Rộng đến', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
        </div>
        <div class="flex items-center space-x-2">
            <?= Html::textInput('PropertiesSearch[area_length_from]', $searchParams['area_length_from'] ?? null, ['placeholder' => 'Dài từ', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
            <span>đến</span>
            <?= Html::textInput('PropertiesSearch[area_length_to]', $searchParams['area_length_to'] ?? null, ['placeholder' => 'Dài đến', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
        </div>
        <div class="flex items-center space-x-2">
            <?= Html::textInput('PropertiesSearch[price_from]', $searchParams['price_from'] ?? null, ['placeholder' => 'Giá từ', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
            <span>đến</span>
            <?= Html::textInput('PropertiesSearch[price_to]', $searchParams['price_to'] ?? null, ['placeholder' => 'Giá đến', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
        </div>

        <!-- SỬA LỖI: Thêm lại cột Diện tích bị thiếu -->
        <div class="flex items-center space-x-2">
            <?= Html::textInput('PropertiesSearch[area_from]', $searchParams['area_from'] ?? null, ['placeholder' => 'Diện tích từ', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
            <span>đến</span>
            <?= Html::textInput('PropertiesSearch[area_to]', $searchParams['area_to'] ?? null, ['placeholder' => 'Diện tích đến', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
        </div>

        <div class="flex space-x-2 col-span-full xl:col-span-1">
            <?= Html::submitButton('<i class="fas fa-search mr-2"></i> TÌM', ['class' => 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200 w-full']) ?>
            
            <?= Html::button('<i class="fas fa-sync-alt"></i>', [
                'type' => 'button',
                'class' => 'bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200',
                'title' => 'Làm mới bộ lọc',
                'onclick' => 'window.resetSearchForm()',
            ]) ?>

            <?= Html::button('<i class="fas fa-chevron-down transition-transform duration-300" :class="{\'rotate-180\': advancedSearchOpen}"></i>', [
                'type' => 'button',
                'class' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow-md',
                'title' => 'Tìm kiếm nâng cao',
                '@click' => 'advancedSearchOpen = !advancedSearchOpen'
            ]) ?>
        </div>
    </div>

    <div x-show="advancedSearchOpen" x-ref="advancedFieldsContainer" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200" class="origin-top">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mt-4 pt-4 border-t">
            <div class="flex items-center space-x-2">
                <?= Html::textInput('PropertiesSearch[update_by]', $searchParams['update_by'] ?? null, ['placeholder' => 'Người cập nhật', 'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500']) ?>
                <?php
    // Giữ nguyên đoạn PHP này
    $selectedAssetTypeIds = [];
    $assetTypeValue = $searchParams['asset_type_id'] ?? [];
    if (!empty($assetTypeValue) && is_string($assetTypeValue)) {
        $selectedAssetTypeIds = array_map('intval', explode(',', $assetTypeValue));
    } elseif (is_array($assetTypeValue)) {
        $selectedAssetTypeIds = $assetTypeValue;
    }
    $assetTypes = $assetTypes ?? [];
?>

<div x-data="{ initialized: false }" class="relative w-full">

    <button x-show="!initialized" @click="initialized = true" type="button" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <span>
            <?php if (empty($selectedAssetTypeIds)): ?>
                <span class="text-gray-800">Chọn Loại Tài Sản</span>
            <?php else: ?>
                <span class="text-gray-700">Đã chọn: <?= count($selectedAssetTypeIds) ?> loại</span>
            <?php endif; ?>
        </span>
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
    </button>

    <template x-if="initialized">
        <div x-data="{
                open: false,
                selected: <?php echo json_encode($selectedAssetTypeIds); ?>,
                toggle(id) { if (this.selected.includes(id)) { this.selected = this.selected.filter(i => i !== id) } else { this.selected.push(id) } },
                clearAll() { this.selected = [] }
            }"
            @reset-form.window="selected = []"
            class="relative w-full" x-cloak
            x-init="
                $watch('selected', val => { document.getElementById('asset_type_id_hidden').value = val.join(','); });
                $nextTick(() => open = true);
            "
            @click.away="open = false"
        >
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span>
                    <template x-if="selected.length === 0"><span class="text-gray-800">Chọn Loại Tài Sản</span></template>
                    <template x-if="selected.length > 0"><span class="text-gray-700" x-text="'Đã chọn: ' + selected.length + ' loại'"></span></template>
                </span>
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="open" x-transition class="absolute z-10 bg-white border border-gray-200 rounded-md shadow-lg w-full mt-2">
                <div x-show="selected.length > 0" class="border-b border-gray-200">
                    <button type="button" @click="clearAll(); open = false" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Xóa tất cả lựa chọn
                    </button>
                </div>
                <ul class="py-1 max-h-60 overflow-y-auto">
                    <?php foreach ($assetTypes as $type): ?>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                            <input type="checkbox" value="<?= $type->asset_type_id; ?>" :checked="selected.includes(<?= $type->asset_type_id; ?>)" @change="toggle(<?= $type->asset_type_id; ?>)" class="mr-2 rounded" id="asset-type-<?= $type->asset_type_id; ?>">
                            <label for="asset-type-<?= $type->asset_type_id; ?>" class="flex-grow cursor-pointer"><?= Html::encode($type->type_name); ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            </div>
    </template>

    <input
        type="hidden"
        name="PropertiesSearch[asset_type_id]"
        id="asset_type_id_hidden"
        class="resettable-hidden-input"
        value="<?= implode(',', $selectedAssetTypeIds) ?>"
    />
</div>
            </div>
            <div class="flex items-center space-x-2">
                <?php
    // Giữ nguyên đoạn PHP này
    $selectedAdvantageIds = [];
    $advantageValue = $searchParams['advantage_ids'] ?? [];
    if (!empty($advantageValue) && is_string($advantageValue)) {
        $selectedAdvantageIds = array_map('intval', explode(',', $advantageValue));
    } elseif (is_array($advantageValue)) {
        $selectedAdvantageIds = $advantageValue;
    }
    $advantages = $advantages ?? [];
?>

<div x-data="{ initialized: false }" class="relative w-full">

    <button x-show="!initialized" @click="initialized = true" type="button" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <span>
            <?php if (empty($selectedAdvantageIds)): ?>
                <span class="text-gray-800">Chọn Ưu điểm</span>
            <?php else: ?>
                <span class="text-gray-700">Đã chọn: <?= count($selectedAdvantageIds) ?> ưu điểm</span>
            <?php endif; ?>
        </span>
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
    </button>

    <template x-if="initialized">
        <div x-data="{
                open: false,
                selected: <?php echo json_encode($selectedAdvantageIds); ?>,
                toggle(id) { if (this.selected.includes(id)) { this.selected = this.selected.filter(i => i !== id); } else { this.selected.push(id); } },
                clearAll() { this.selected = [] }
            }"
            @reset-form.window="selected = []"
            class="relative w-full" x-cloak
            x-init="
                $watch('selected', val => { document.getElementById('advantage_ids_hidden').value = val.join(','); });
                $nextTick(() => open = true);
            "
            @click.away="open = false"
        >
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span>
                    <template x-if="selected.length === 0"><span class="text-gray-800">Chọn Ưu điểm</span></template>
                    <template x-if="selected.length > 0"><span class="text-gray-700" x-text="'Đã chọn: ' + selected.length + ' ưu điểm'"></span></template>
                </span>
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="open" x-transition class="absolute z-10 bg-white border border-gray-200 rounded-md shadow-lg w-full mt-2">
                <div x-show="selected.length > 0" class="border-b border-gray-200">
                    <button type="button" @click="clearAll()" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Xóa tất cả lựa chọn
                    </button>
                </div>
                <ul class="py-1 max-h-60 overflow-y-auto">
                    <?php foreach ($advantages as $advantage): ?>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                            <input type="checkbox" value="<?= $advantage->advantage_id; ?>" :checked="selected.includes(<?= $advantage->advantage_id; ?>)" @change="toggle(<?= $advantage->advantage_id; ?>)" class="mr-2 rounded" id="adv-<?= $advantage->advantage_id; ?>">
                            <label for="adv-<?= $advantage->advantage_id; ?>" class="flex-grow cursor-pointer"><?= Html::encode($advantage->name); ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            </div>
    </template>

    <input
        type="hidden"
        name="PropertiesSearch[advantage_ids]"
        id="advantage_ids_hidden"
        class="resettable-hidden-input"
        value="<?= implode(',', $selectedAdvantageIds) ?>"
    />
</div>
            </div>
            <div class="flex items-center space-x-2">
                <?php
    // Giữ nguyên đoạn PHP này
    $selectedDisadvantageIds = [];
    $disadvantageValue = $searchParams['disadvantage_ids'] ?? [];
    if (!empty($disadvantageValue) && is_string($disadvantageValue)) {
        $selectedDisadvantageIds = array_map('intval', explode(',', $disadvantageValue));
    } elseif (is_array($disadvantageValue)) {
        $selectedDisadvantageIds = $disadvantageValue;
    }
    $disadvantages = $disadvantages ?? [];
?>

<div x-data="{ initialized: false }" class="relative w-full">

    <button x-show="!initialized" @click="initialized = true" type="button" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <span>
            <?php if (empty($selectedDisadvantageIds)): ?>
                <span class="text-gray-800">Chọn Nhược điểm</span>
            <?php else: ?>
                <span class="text-gray-700">Đã chọn: <?= count($selectedDisadvantageIds) ?> nhược điểm</span>
            <?php endif; ?>
        </span>
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
    </button>

    <template x-if="initialized">
        <div x-data="{
                open: false,
                selected: <?php echo json_encode($selectedDisadvantageIds); ?>,
                toggle(id) { 
                    if (this.selected.includes(id)) { 
                        this.selected = this.selected.filter(i => i !== id); 
                    } else { 
                        this.selected.push(id); 
                    } 
                },
                clearAll() { 
                    this.selected = [];
                }
            }"
            @reset-form.window="selected = []"
            class="relative w-full" x-cloak
            x-init="
                $watch('selected', val => { document.getElementById('disadvantage_ids_hidden').value = val.join(','); });
                $nextTick(() => open = true);
            "
            @click.away="open = false"
        >
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span>
                    <template x-if="selected.length === 0"><span class="text-gray-800">Chọn Nhược điểm</span></template>
                    <template x-if="selected.length > 0"><span class="text-gray-700" x-text="'Đã chọn: ' + selected.length + ' nhược điểm'"></span></template>
                </span>
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="open" x-transition class="absolute z-10 bg-white border border-gray-200 rounded-md shadow-lg w-full mt-2">
                <div x-show="selected.length > 0" class="border-b border-gray-200">
                    <button type="button" @click="clearAll()" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Xóa tất cả lựa chọn
                    </button>
                </div>
                <ul class="py-1 max-h-60 overflow-y-auto">
                    <?php foreach ($disadvantages as $disadvantage): ?>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                            <input type="checkbox" value="<?= $disadvantage->disadvantage_id; ?>" :checked="selected.includes(<?= $disadvantage->disadvantage_id; ?>)" @change="toggle(<?= $disadvantage->disadvantage_id; ?>)" class="mr-2 rounded" id="disadv-<?= $disadvantage->disadvantage_id; ?>">
                            <label for="disadv-<?= $disadvantage->disadvantage_id; ?>" class="flex-grow cursor-pointer"><?= Html::encode($disadvantage->disadvantage_name); ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            </div>
    </template>

    <input
        type="hidden"
        name="PropertiesSearch[disadvantage_ids]"
        id="disadvantage_ids_hidden"
        class="resettable-hidden-input"
        value="<?= implode(',', $selectedDisadvantageIds) ?>"
    />
</div>
            </div>
            
            <div class="flex items-center space-x-2">
                <?php
    // Giữ nguyên đoạn PHP này
    $selectedDirectionIds = [];
    $directionValue = $searchParams['direction_ids'] ?? [];
    if (!empty($directionValue) && is_string($directionValue)) {
        $selectedDirectionIds = array_map('intval', explode(',', $directionValue));
    } elseif (is_array($directionValue)) {
        $selectedDirectionIds = $directionValue;
    }
    $directions = $directions ?? [];
?>

<div x-data="{ initialized: false }" class="relative w-full">

    <button x-show="!initialized" @click="initialized = true" type="button" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <span>
            <?php if (empty($selectedDirectionIds)): ?>
                <span class="text-gray-800">Chọn Hướng</span>
            <?php else: ?>
                <span class="text-gray-700">Đã chọn: <?= count($selectedDirectionIds) ?> hướng</span>
            <?php endif; ?>
        </span>
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
    </button>

    <template x-if="initialized">
        <div x-data="{
                open: false,
                selected: <?php echo json_encode($selectedDirectionIds); ?>,
                toggle(id) { 
                    if (this.selected.includes(id)) { 
                        this.selected = this.selected.filter(i => i !== id); 
                    } else { 
                        this.selected.push(id); 
                    } 
                },
                clearAll() { 
                    this.selected = [];
                }
            }"
            @reset-form.window="selected = []"
            class="relative w-full" x-cloak
            x-init="
                $watch('selected', val => { document.getElementById('direction_ids_hidden').value = val.join(','); });
                $nextTick(() => open = true);
            "
            @click.away="open = false"
        >
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between text-left bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span>
                    <template x-if="selected.length === 0"><span class="text-gray-800">Chọn Hướng</span></template>
                    <template x-if="selected.length > 0"><span class="text-gray-700" x-text="'Đã chọn: ' + selected.length + ' hướng'"></span></template>
                </span>
                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
            <div x-show="open" x-transition class="absolute z-10 bg-white border border-gray-200 rounded-md shadow-lg w-full mt-2">
                <div x-show="selected.length > 0" class="border-b border-gray-200">
                    <button type="button" @click="clearAll()" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Xóa tất cả lựa chọn
                    </button>
                </div>
                <ul class="py-1 max-h-60 overflow-y-auto">
                    <?php foreach ($directions as $direction): ?>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                            <input type="checkbox" value="<?= $direction->id; ?>" :checked="selected.includes(<?= $direction->id; ?>)" @change="toggle(<?= $direction->id; ?>)" class="mr-2 rounded" id="dir-<?= $direction->id; ?>">
                            <label for="dir-<?= $direction->id; ?>" class="flex-grow cursor-pointer"><?= Html::encode($direction->name); ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            </div>
    </template>

    <input
        type="hidden"
        name="PropertiesSearch[direction_ids]"
        id="direction_ids_hidden"
        class="resettable-hidden-input"
        value="<?= implode(',', $selectedDirectionIds) ?>"
    />
</div>

                
            </div>
            <div class="flex items-center space-x-2">
                <?= Html::textInput(
                    'PropertiesSearch[num_floors_from]',
                    $searchParams['num_floors_from'] ?? null,
                    [
                        'placeholder' => 'Số tầng từ',
                        'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500',
                        'type' => 'number',
                        'min' => 1,
                        'oninput' => "if(this.value===''){this.value='';}else{this.value=this.value.replace(/[^0-9]/g,'')}"
                    ]
                ) ?>
                <span>đến</span>
                <?= Html::textInput(
                    'PropertiesSearch[num_floors_to]',
                    $searchParams['num_floors_to'] ?? null,
                    [
                        'placeholder' => 'Số tầng đến',
                        'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500',
                        'type' => 'number',
                        'min' => 1,
                        'oninput' => "if(this.value===''){this.value='';}else{this.value=this.value.replace(/[^0-9]/g,'')}"
                    ]
                ) ?>
            </div>

            <div class="flex items-center space-x-2">
    <?php
        // Biến $searchParams đã được định nghĩa ở đầu file
    ?>
    <?= Html::textInput(
        'PropertiesSearch[num_bedrooms_from]',
        $searchParams['num_bedrooms_from'] ?? null,
        [
            'placeholder' => 'Số phòng ngủ từ',
            'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500',
            'type' => 'number',
            'min' => 1,
            'oninput' => "if(this.value===''){this.value='';}else{this.value=this.value.replace(/[^0-9]/g,'')}"
        ]
    ) ?>
    <span>đến</span>
    <?= Html::textInput(
        'PropertiesSearch[num_bedrooms_to]',
        $searchParams['num_bedrooms_to'] ?? null,
        [
            'placeholder' => 'Số phòng ngủ đến',
            'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500',
            'type' => 'number',
            'min' => 1,
            'oninput' => "if(this.value===''){this.value='';}else{this.value=this.value.replace(/[^0-9]/g,'')}"
        ]
    ) ?>
</div>

<div class="flex items-center space-x-2">
    <?= Html::textInput(
        'PropertiesSearch[date_from]',
        $searchParams['date_from'] ?? null,
        [
            'placeholder' => 'Ngày tạo từ',
            'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500',
            'type' => 'date' // Dùng type="date" để trình duyệt hiển thị công cụ chọn ngày
        ]
    ) ?>
    <span>đến</span>
    <?= Html::textInput(
        'PropertiesSearch[date_to]',
        $searchParams['date_to'] ?? null,
        [
            'placeholder' => 'Ngày tạo đến',
            'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500',
            'type' => 'date'
        ]
    ) ?>
</div>

        </div>
    </div>

    <div class="border-t border-gray-200 pt-4 mt-4">
        <?php
        $allButtons = [ 
            1 => [
                'label' => 'Tài Sản Đấu Giá', 
                'icon' => 'fa-tag', 
                'color' => 'blue'], 
            2 => [
                'label' => 'Sản Phẩm Mới',   
                'icon' => 'fa-star', 
                'color' => 'yellow'], 
            3 => [
                'label' => 'Đang Giao Dịch',    
                'icon' => 'fa-handshake', 
                'color' => 'green'], 
            4 => [
                'label' => 'Ngừng Giao Dịch',  
                'icon' => 'fa-comments',
                 'color' => 'orange'], 
            5 => [
                'label' => 'Đã Giao Dịch',       
                'icon' => 'fa-money-check-alt', 
                'color' => 'purple'], 
            11 => [
                'label' => 'Đã Cọc',       
                'icon' => 'fa-money-check-alt', 
                'color' => 'purple'], 
            6 => [
                'label' => 'Có HĐ Thuê',     
                'icon' => 'fa-file-invoice', 'color' => 'pink'], 
            7 => [
                'label' => 'Động Tư Trạch',
                'icon' => 'fa-search-location', 
                'color' => 'teal'], 
            8 => ['label' => 'Tẩy Trạch',     'icon' => 'fa-exchange-alt', 'color' => 'indigo'], 
            9 => ['label' => 'Tăng giá',         'icon' => 'fa-arrow-alt-circle-up', 'color' => 'red'], 
            10=> ['label' => 'Giảm giá',        'icon' => 'fa-arrow-alt-circle-down', 'color' => 'gray'],
         ];
        $selectedIds = [];
        $filterValue = $searchParams['status_filters'] ?? ''; 
        if (!empty($filterValue) && is_string($filterValue)) { $selectedIds = array_map('intval', explode(',', $filterValue)); }
        ?>
        <div x-data="{
            selected: <?= json_encode($selectedIds) ?>,
            toggle(id) { if (this.selected.includes(id)) { this.selected = this.selected.filter(i => i !== id); } else { this.selected.push(id); } this.$nextTick(() => { $('#property-search-form').submit(); }); }
        }"
            @reset-form.window="selected = []"
        >
            <input type="hidden" name="PropertiesSearch[status_filters]" :value="selected.join(',')">
            <div class="flex flex-wrap items-center gap-2">
                <?php foreach ($allButtons as $id => $button): ?>
                    <button type="button" @click="toggle(<?= $id ?>)" :class="selected.includes(<?= $id ?>) ? 'bg-<?= $button['color'] ?>-500 text-white ring-2 ring-offset-1 ring-<?= $button['color'] ?>-500' : 'bg-<?= $button['color'] ?>-100 text-<?= $button['color'] ?>-700'" class="flex items-center px-3 py-1 rounded-full text-sm font-medium cursor-pointer transition-transform hover:scale-105">
                        <i class="fas <?= $button['icon'] ?> mr-1.5"></i>
                        <span><?= Html::encode($button['label']) ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

    <div class="flex items-center gap-2 text-sm text-gray-500 mt-4">
        <i class="fas fa-exclamation-triangle text-orange-500"></i>
        <span>Đã Xem Hôm Nay</span>
    </div>
</div>

<?php
$this->registerJs(<<<JS
// Gắn hàm vào window object để đảm bảo phạm vi toàn cục
window.resetSearchForm = function() {
    const form = document.getElementById('property-search-form');
    if (!form) return;

    // Xóa giá trị của tất cả các input text, number và select
    form.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], select').forEach(input => {
        input.value = '';
    });

    form.querySelectorAll('.resettable-hidden-input').forEach(input => {
        input.value = '';
    });

    // Phát ra sự kiện để các component Alpine tự reset
    window.dispatchEvent(new CustomEvent('reset-form'));

    // Đợi một chút để Alpine cập nhật DOM rồi gửi form qua Pjax
    setTimeout(() => {
        $(form).submit();
    }, 100);
}

// Xử lý sau khi Pjax hoàn thành
$(document).on('pjax:end', function () {
    if (typeof Alpine !== 'undefined') {
        // Khởi tạo lại các component Alpine trên nội dung mới được tải
        Alpine.start();
    }
});
JS, \yii\web\View::POS_READY);

?>
