<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PropertyImages;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */

$this->title = "Xem Dữ Liệu Nhà Đất [". $model->property_id . "]";
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

function formatPriceUnit($number) {
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

function formatNumber($number) {
    if ($number === null) {
        return null;
    }
    if ($number == (int)$number) {
        return (int)$number;
    }
    
    return (float)$number;
}
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">
        <?= Html::a('<i class="fas fa-arrow-left"></i>', Yii::$app->request->referrer ?: ['index'], [
        'class' => 'px-4 py-2 bg-blue-500 text-white rounded-full  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500']) ?>    
        <i class="fas fa-database text-xl"></i> Dữ Liệu Nhà Đất [Mã: <?= $model->property_id ?> - Loại Giao Dịch: <?= $model->listingType->name ?>]
    </div>
    <div class="relative flex items-center space-x-4">
        <button
            id="userMenuButton"
            class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="fas fa-user"></i>
        </button>
        <div
            id="userMenu"
            class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="userMenuButton"
        >
            <a href="<?= \yii\helpers\Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= \yii\helpers\Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>


<main class="flex-1 p-6 overflow-y-auto hide-scrollbar">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div id="thong-tin-content" class="tab-content lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>                    
                    <p class="text-sm text-gray-500">Mã BĐS: <span class="font-semibold text-gray-800"><?= Html::encode($model->property_id) ?></span></p>
                    <p class="text-sm text-gray-500">Ngày Nhập: <span class="font-semibold text-gray-800"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?> (<?= Yii::$app->formatter->asDate($model->created_at, 'php:d-m-Y') ?>)</span></p>
                </div>
                <div class="flex items-center space-x-2">
                    <div>
                        <p class="text-sm text-gray-500">Người Nhập:</p>
                        <p class="font-semibold text-gray-800"><?= Yii::$app->user->identity->username ?> <i class="fas fa-info-circle text-gray-400 text-xs"></i></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-orange-600-custom">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-orange-600"><?= Html::encode($model->listingType->name ?? '') ?></span>
                        <?= Html::tag('div', $model->propertyType->type_name ?? null, [
                            'class' => 'tab-sub-button px-4 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200'
                            ]) 
                        ?>
                        <?php if ($model->transactionStatus && $model->transactionStatus->transaction_status_id !== 0): ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?= Html::encode($model->transactionStatus->class_css) ?>">
                                <?= Html::encode($model->transactionStatus->status_name) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="text-xl font-bold text-gray-800 mb-2"><?= Html::encode($model->title) ?></p>
                <?= 
                    Html::a(
                        '<i class="fas fa-map mr-1"></i> Xem bản đồ',
                        "https://maps.google.com/?q=".$model->title,
                        [
                            'target' => '_blank',
                            'class' => 'px-4 py-2 text-sm font-medium rounded-full bg-blue-100 text-blue-700',
                            'encode' => false,
                        ]
                    )
                ?>
                <?= 
                    $model->new_district
                    ? Html::tag('span', $model->new_district, [
                        'class' => 'capitalize px-4 py-2 text-sm font-medium rounded-full bg-green-100 text-green-700'])
                    : '';
                ?>
                <div class="grid grid-cols-3 gap-4 mb-4 mt-4">
                    <?php
                        $totalPrice = $model->price; 
                        $totalArea = $model->area_total;
                        $pricePerSqM_Text = '';

                        if ($totalArea > 0 && $totalPrice > 0) {
                            $pricePerSqM_VND = $totalPrice / $totalArea;
                            $pricePerSqM_Text = formatPriceUnit($pricePerSqM_VND);
                        }
                    ?>

                    <div>
                        <p class="text-sm text-gray-500">Mức giá</p>
                        <p class="text-lg font-bold text-gray-800">
                            <?= formatPriceUnit($model->price) ?>
                        </p>
                        <p class="text-xs text-gray-500">
                            ~ <?= $pricePerSqM_Text ?>/m²
                        </p>
                    </div>
                    <? if (!empty($model->final_price) && $model->final_price > 0):  ?>
                        <?php
                        $totalFinalPrice = $model->final_price; 
                        $totalArea = $model->area_total;
                        $pricePerSqM_Text = '';

                        if ($totalArea > 0 && $totalFinalPrice > 0) {
                            $pricePerSqM_VND = $totalFinalPrice / $totalArea;
                            $pricePerSqM_Text = formatPriceUnit($pricePerSqM_VND);
                        }
                        ?>
                        <div>
                            <p class="text-sm text-gray-500">Giá chốt</p>
                            <p class="text-lg font-bold text-gray-800">
                                <?= formatPriceUnit($model->final_price) ?>
                            </p>
                            <p class="text-xs text-gray-500">
                                ~ <?= $pricePerSqM_Text ?>/m²
                            </p>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="text-sm text-gray-500">Diện tích</p>
                        <p class="text-lg font-bold text-gray-800">
                            <?= formatNumber($model->area_total) ?> m²
                        </p>
                        <p class="text-xs text-gray-500">
                            (<?= formatNumber($model->area_length) ?>m × <?= formatNumber($model->area_width) ?>m)
                        </p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <?php foreach ($model->ownerContacts as $contact): ?>
                        <?php
                        if ($contact->gender_id == 2) {
                            $iconClass = 'fas fa-venus text-pink-500';
                        } else {
                            $iconClass = 'fas fa-mars text-blue-600';
                        }
                        ?>
                        
                        <div class="flex items-center font-medium contact-entry" data-contact-id="<?= Html::encode($contact->contact_id) ?>">
                            <i class="<?= $iconClass ?> mr-2 w-4 text-center"></i>
                            <span class="text-gray-800 contact-info cursor-pointer hover:text-blue-600" title="Click to reveal phone number">
                                <?= Html::encode($contact->contact_name) ?> <span class="phone-display">•••••••<?= substr($contact->phone_number, -3) ?></span>
                            </span>
                            <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                <?= Html::encode($contact->role->name ?? 'Chủ nhà') ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <nav class="flex space-x-4 mb-4">
                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-orange-100 text-orange-700" data-target="vi-tri-mat-tien">Vị Trí <?= Html::encode($model->locationTypes->type_name ?? '') ?></button>
                    <?php
                        $assetTypeName = 'chưa có thông tin';
                        if ($model->assetType && $model->assetType->asset_type_id !== 0) {
                            $assetTypeName = $model->assetType->type_name;
                        }
                    ?>

                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200" data-target="loai-tai-san-ca-nhan">
                        Loại Tài Sản <?= Html::encode($assetTypeName) ?>
                    </button>
                </nav>

                <div id="vi-tri-mat-tien" class="tab-sub-content space-y-4">
                    <div class="flex items-start justify-between">
                        <p class="text-gray-700">Nhà có diện tích <?= formatNumber($model->area_length) ?>m × <?= formatNumber($model->area_width) ?>m, khu trung tâm kinh doanh buôn bán ,tiện kinh doanh đa ngành nghề</p>
                        <button class="ml-4 text-gray-500 hover:text-gray-700 flex items-center text-sm">
                            <i class="far fa-copy mr-1"></i> Copy
                        </button>
                    </div>
                    <p class="text-gray-700"><?= formatPriceUnit($model->price) ?> tỷ (<?= formatNumber($model->area_length) ?>m × <?= formatNumber($model->area_width) ?>m)</p>
                    <button class="px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-full hover:bg-red-200">Đánh dấu Hot</button>
                </div>

                <div id="loai-tai-san-ca-nhan" class="tab-sub-content hidden space-y-4">
                    <p class="text-gray-700">Thông tin chi tiết về loại tài sản cá nhân sẽ được hiển thị tại đây.</p>
                </div>
            </div>

            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-md font-semibold text-gray-800 mb-3">Sổ Hồng & Hình Ảnh</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 uploaded-images">
                    <?php
                    $images = $model->propertyImages;
                    foreach ($images as $image) {
                        // Get the absolute URL for the image
                        $imageUrl = Html::encode(Yii::$app->urlManager->createAbsoluteUrl($image->image_path));

                        echo "<div class='relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container'>";
                        echo "<img src='{$imageUrl}' alt='" . Html::encode($image->image_path) . "' class='object-cover w-full h-full'>";

                        // Overlay with view button
                        echo "<div class='absolute inset-0 bg-opacity-50 flex items-center justify-center'>";
                        echo "<button class='view-image-button p-3 bg-white text-gray-800 rounded-full shadow-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500' data-image-url='{$imageUrl}'>";
                        echo "<i class='fas fa-eye'></i>"; // Font Awesome eye icon
                        echo "</button>";
                        echo "</div>"; // End overlay

                        echo "</div>"; // End image-container
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="imageViewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 hidden">
            <div class="relative max-w-3xl max-h-[90vh] p-4 bg-white rounded-lg shadow-xl overflow-auto">
                <button id="closeImageViewModal" class="absolute top-2 right-2 p-2 text-gray-600 hover:text-gray-900 text-2xl">
                    &times;
                </button>
                <img id="modalImageView" src="" alt="Property Image" class="max-w-full max-h-[85vh] object-contain mx-auto my-0">
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
             <!-- User Info Card -->
            <div class="bg-white p-6 rounded-lg shadow-md space-y-4">
                <p class="text-sm text-gray-500"><?=  Yii::$app->formatter->asRelativeTime(Yii::$app->user->identity->updated_at) ?> | <?= Yii::$app->user->identity->username ?> | <?= Yii::$app->user->identity->full_name ?> | <?= Yii::$app->user->identity->phone ?></p>
                <button id="add-contact-button" class="w-full py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 flex items-center justify-center space-x-2">
                    <i class="fas fa-address-book"></i>
                    <span>Thêm Thông Tin Liên Hệ</span>
                </button>
               
                <div class="space-y-2 flex flex-col text-blue-600 font-medium">
                    <?php foreach ($model->ownerContacts as $contact): ?>
                        <?php
                        if ($contact->gender_id == 2) {
                            $iconClass = 'fas fa-venus text-pink-500';
                        } else {
                            $iconClass = 'fas fa-mars text-blue-600';
                        }
                        ?>
                        
                        <div class="flex items-center font-medium w-full">
                            <i class="<?= $iconClass ?> mr-2 w-4 text-center"></i> <span class="text-gray-800">
                                <?= Html::encode($contact->contact_name) ?> •••••••<?= substr($contact->phone_number, -3) ?>
                            </span>
                            <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full"><?= Html::encode($contact->role->name ?? 'Chủ nhà') ?></span>
                        </div>
                        </br>

                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Loại Tài Sản Card -->
            <div class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <p class="text-sm text-gray-500">
                Loại Tài Sản:
                <span class="font-semibold text-gray-800">
                    <?= $model->assetType ? $model->assetType->type_name : '(Chưa xác định)' ?>
                </span>
            </p>
            <p class="text-sm text-gray-500">
                Đánh dấu:
                <span class="font-semibold text-green-700">
                    <?= $model->transactionStatus ? $model->transactionStatus->status_name : '(Chưa xác định)' ?>
                </span>
            </p>

                <p class="text-sm text-gray-500">Mức giá: <span class="font-bold text-gray-800"><?= formatPriceUnit($model->price) ?></span> <i class="fas fa-arrow-up text-green-500 ml-1"></i></p>
                <p class="text-sm text-gray-500">Giá trên m2: <span class="font-bold text-gray-800"><?= $pricePerSqM_Text ?> </span></p>
                <button class="px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-full hover:bg-green-200 flex items-center space-x-2">
                    <i class="fas fa-check-circle"></i>
                    <span>Xác minh bởi</span>
                    <span class="font-semibold"><?= Yii::$app->user->identity->username ?></span>
                </button>
            </div>
            <!-- Another similar section (TIN GÓC) -->
           
            <?php foreach ($modelActivityLogs as $log): ?>
                <div class="bg-white p-6 rounded-lg shadow-md space-y-2">
                    <p class="text-sm text-gray-500">
                        <span class="font-medium text-gray-800">
                            <?= $log->user ? Html::encode($log->user->username) : 'Hệ thống' ?>
                        </span>
                        <span class="text-gray-400 mx-1">•</span>
                        <span><?= Yii::$app->formatter->asRelativeTime($log->created_at) ?></span>
                    </p>

                    <?php if (!empty($log->details)): ?>
                        <p class="text-gray-700">
                            <?= nl2br(Html::encode($log->details)) ?>
                        </p>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<div id="contact-modal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Thêm Thông Tin Liên Hệ</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="contact-role" class="block text-sm font-medium text-gray-700 mb-1">Vai Trò</label>
                <select id="contact-role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                <option value="">Chọn Vai Trò</option>
                    <option value="0">Không xác định</option>
                    <option value="1">Chủ nhà</option>
                    <option value="2">Độc Quyền</option>
                    <option value="3">Môi Giới Hợp Tác</option>
                    <option value="4">Người Thân Chủ Nhà</option>
                    <option value="5">Trợ Lý Chủ Nhà</option>
                    <option value="6">Đại Diện Công Ty</option>
                    <option value="7">Đại Diện Chủ Nhà</option>
                    <option value="8">Đầu Tư</option>
                </select>
            </div>
            <div>
                <label for="contact-name" class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
                <input type="text" id="contact-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
            </div>
            <div>
                <label for="contact-phone" class="block text-sm font-medium text-gray-700 mb-1">Điện thoại</label>
                <input type="text" id="contact-phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
            </div>
            <div>
                <label for="contact-gender" class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
                <select id="contact-gender" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    <option >Chọn Giới tính</option>
                    <option value="1">Nam</option>
                    <option value="2">Nữ</option>
                    <option value="0">Khác</option>
                </select>
            </div>
            <input type="hidden" id="properties-property_id" value="<?= $model->property_id ?>">
        </div>
        <div class="flex justify-end mt-6 space-x-2">
            <button id="save-contact-button" class="px-4 py-2 bg-orange-600 text-white rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Lưu</button>
            <button id="cancel-contact-button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Hủy</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const addContactButton = document.getElementById('add-contact-button');
        const contactModal = document.getElementById('contact-modal');
        const closeButton = contactModal.querySelector('.close-button');
        const saveContactButton = document.getElementById('save-contact-button');
        const cancelContactButton = document.getElementById('cancel-contact-button');
        const contactEntriesDiv = document.getElementById('contact-entries');

        // --- Image View Modal Logic ---
        const imageViewModal = document.getElementById('imageViewModal');
        const modalImageView = document.getElementById('modalImageView');
        const closeImageViewModalButton = document.getElementById('closeImageViewModal');
        const viewImageButtons = document.querySelectorAll('.view-image-button'); // Select all view buttons

        // Function to open the image modal
        function openImageViewModal(imageUrl) {
            if (modalImageView && imageViewModal) {
                modalImageView.src = imageUrl;
                imageViewModal.classList.remove('hidden'); // Show the modal
                document.body.style.overflow = 'hidden'; // Prevent scrolling of the body
            }
        }

        // Function to close the image modal
        function closeImageViewModal() {
            if (imageViewModal) {
                imageViewModal.classList.add('hidden'); // Hide the modal
                modalImageView.src = ''; // Clear the image source
                document.body.style.overflow = ''; // Restore body scrolling
            }
        }

        // Add click listener to each view button
        viewImageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image-url');
                if (imageUrl) {
                    openImageViewModal(imageUrl);
                }
            });
        });

        // Add click listener to the close button inside the modal
        if (closeImageViewModalButton) {
            closeImageViewModalButton.addEventListener('click', closeImageViewModal);
        }

        // Close modal if clicked outside the content (on the overlay)
        if (imageViewModal) {
            imageViewModal.addEventListener('click', function(event) {
                if (event.target === imageViewModal) { // Check if the click was directly on the overlay
                    closeImageViewModal();
                }
            });
        }

        // Close modal on Escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !imageViewModal.classList.contains('hidden')) {
                closeImageViewModal();
            }
        });


        // Show the modal when "Thêm Liên Hệ" button is clicked
        addContactButton.addEventListener('click', function() {
            contactModal.style.display = 'flex'; // Use flex to center the modal
        });

        // Hide the modal when close button or Cancel is clicked
        closeButton.addEventListener('click', function() {
            contactModal.style.display = 'none';
        });

        cancelContactButton.addEventListener('click', function() {
            contactModal.style.display = 'none';
        });

        // Hide the modal if user clicks outside of it
        window.addEventListener('click', function(event) {
            if (event.target == contactModal) {
                contactModal.style.display = 'none';
            }
        });

        const contactEntries = document.querySelectorAll('.contact-entry');
        contactEntries.forEach(entry => {
            const contactInfo = entry.querySelector('.contact-info');
            contactInfo.addEventListener('click', function() {
                const contactId = entry.getAttribute('data-contact-id');
                const phoneDisplay = entry.querySelector('.phone-display');

                // Prevent multiple requests if already revealed
                if (phoneDisplay.classList.contains('revealed')) {
                    return;
                }

                // Show loading state
                phoneDisplay.textContent = 'Đang tải...';

                // Ajax request to get full phone number
                fetch('/property/get-phone', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': yii.getCsrfToken()
                    },
                    body: JSON.stringify({
                        contact_id: contactId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.phone_number) {
                        phoneDisplay.textContent = data.phone_number;
                        phoneDisplay.classList.add('revealed');
                    } else {
                        phoneDisplay.textContent = 'Lỗi: Không lấy được số điện thoại';
                        console.error('Error:', data.error || 'Unknown error');
                    }
                })
                .catch(error => {
                    phoneDisplay.textContent = 'Lỗi kết nối';
                    console.error('Fetch error:', error);
                });
            });
        });
    });

    document.getElementById('save-contact-button').addEventListener('click', function () {
        const role = document.getElementById('contact-role').value;
        const name = document.getElementById('contact-name').value;
        const phone = document.getElementById('contact-phone').value;
        const gender = document.getElementById('contact-gender').value;
        const propertyId = document.getElementById('properties-property_id').value;


        // Kiểm tra dữ liệu cơ bản
        if (!name || !phone || role === 'Chọn Vai Trò' || gender === 'Chọn Giới tính') {
            alert('Vui lòng điền đầy đủ thông tin.');
            return;
        }

        // Gửi Ajax
        fetch('/owner-contact/create-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': yii.getCsrfToken()
            },
            body: JSON.stringify({
                role: role,
                name: name,
                phone: phone,
                gender: gender,
                propertyId: propertyId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi lưu!');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Lỗi kết nối máy chủ.');
        });
    });


</script>