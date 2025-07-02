<?php
use yii\helpers\Html;

// Set page title
$this->title = 'Xem Vị trí Nhân viên';

// Register CSS dependencies (Font Awesome and Tailwind CSS)
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', ['position' => \yii\web\View::POS_HEAD]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', ['position' => \yii\web\View::POS_HEAD]);

// Register custom CSS for map and alert
$this->registerCss('
    #map {
        height: 400px; /* Set a fixed height for the map */
        width: 100%;
        border-radius: 8px;
    }
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        z-index: 1000;
    }
    .custom-alert.show {
        opacity: 1;
    }
');
?>

<!-- Header -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Xem Vị trí của nhân viên</div>
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

<main class="flex-1 p-6 overflow-auto">
    <!-- Custom Alert Box -->
    <div id="custom-alert-box" class="custom-alert"></div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Xem Vị trí của nhân viên</h2>

        <div class="mb-4 text-center">
            <p class="text-lg text-gray-700">
                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                Vĩ độ: <span id="latitude" class="font-semibold text-blue-600">Đang tải...</span>
            </p>
            <p class="text-lg text-gray-700 mt-2">
                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                Kinh độ: <span id="longitude" class="font-semibold text-blue-600">Đang tải...</span>
            </p>
            <p id="location-status" class="text-sm text-gray-500 mt-4">Đang cố gắng lấy vị trí của bạn...</p>
        </div>

        <div id="map" class="mt-6"></div>

        <div class="flex justify-center pt-6">
            <button id="refresh-location"
                    class="px-5 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <i class="fas fa-sync-alt mr-2"></i> Cập nhật vị trí
            </button>
        </div>
    </div>
</main>

<!-- Define initMap in global scope before loading Google Maps API -->
<script>
    // Initialize map variables
    let map;
    let marker;
    const defaultHCMC = { lat: 10.762622, lng: 106.660172 }; // Center of Ho Chi Minh City

    // Define initMap globally
    window.initMap = function() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultHCMC,
            zoom: 12,
        });

        marker = new google.maps.Marker({
            position: defaultHCMC,
            map: map,
            title: "Vị trí hiện tại",
        });

        // Attempt to get user's current location
        getLocation();

        // Add event listener to the refresh button
        document.getElementById("refresh-location").addEventListener("click", getLocation);
    };
</script>

<?php
// Register Google Maps API with a valid key (store key in params.php or config)
$googleMapsApiKey = Yii::$app->params['googleMapsApiKey'] ?? 'AIzaSyBal4PU2T0poc6U14VZ7B6R9TvNpLd0eY4';
$this->registerJsFile("https://maps.googleapis.com/maps/api/js?key={$googleMapsApiKey}&callback=initMap", ['async' => true, 'defer' => true]);

// Register additional JavaScript for other functionality
$this->registerJs('
    // Function to display custom alert messages
    function showCustomAlert(message, type = "error") {
        const alertBox = document.getElementById("custom-alert-box");
        alertBox.textContent = message;
        alertBox.className = `custom-alert show ${type === "success" ? "bg-green-100 text-green-700 border-green-400" : "bg-red-100 text-red-700 border-red-400"}`;
        setTimeout(() => {
            alertBox.classList.remove("show");
        }, 3000); // Hide after 3 seconds
    }

    // Toggle user menu visibility
    document.getElementById("userMenuButton").addEventListener("click", () => {
        const userMenu = document.getElementById("userMenu");
        userMenu.classList.toggle("hidden");
    });

    // Close user menu when clicking outside
    document.addEventListener("click", (event) => {
        const userMenu = document.getElementById("userMenu");
        const userMenuButton = document.getElementById("userMenuButton");
        if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
            userMenu.classList.add("hidden");
        }
    });

    // Function to get user location
    function getLocation() {
        const latElement = document.getElementById("latitude");
        const lngElement = document.getElementById("longitude");
        const statusElement = document.getElementById("location-status");

        latElement.textContent = "Đang tải...";
        lngElement.textContent = "Đang tải...";
        statusElement.textContent = "Đang cố gắng lấy vị trí của bạn...";

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const userLocation = { lat: userLat, lng: userLng };

                    latElement.textContent = userLat.toFixed(6);
                    lngElement.textContent = userLng.toFixed(6);
                    statusElement.textContent = "Vị trí của bạn đã được cập nhật.";

                    map.setCenter(userLocation);
                    marker.setPosition(userLocation);
                    map.setZoom(15); // Zoom in closer when user location is found
                    showCustomAlert("Vị trí của bạn đã được tìm thấy!", "success");
                },
                (error) => {
                    console.error("Lỗi khi lấy vị trí:", error);
                    latElement.textContent = defaultHCMC.lat.toFixed(6);
                    lngElement.textContent = defaultHCMC.lng.toFixed(6);
                    statusElement.textContent = "Không thể lấy vị trí của bạn. Hiển thị vị trí mặc định (TP. Hồ Chí Minh).";

                    map.setCenter(defaultHCMC);
                    marker.setPosition(defaultHCMC);
                    map.setZoom(12); // Default zoom
                    showCustomAlert("Không thể lấy vị trí của bạn. Vui lòng cấp quyền truy cập vị trí.", "error");
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000, // 10 seconds
                    maximumAge: 0 // No cached position
                }
            );
        } else {
            // Browser doesn\'t support Geolocation
            latElement.textContent = defaultHCMC.lat.toFixed(6);
            lngElement.textContent = defaultHCMC.lng.toFixed(6);
            statusElement.textContent = "Trình duyệt của bạn không hỗ trợ Geolocation API. Hiển thị vị trí mặc định (TP. Hồ Chí Minh).";
            map.setCenter(defaultHCMC);
            marker.setPosition(defaultHCMC);
            map.setZoom(12); // Default zoom
            showCustomAlert("Trình duyệt không hỗ trợ Geolocation API.", "error");
        }
    }

    // Error handling for Google Maps API loading issues
    window.onerror = function(message, source, lineno, colno, error) {
        if (message.includes("google")) {
            showCustomAlert("Không thể tải Google Maps. Vui lòng kiểm tra kết nối mạng hoặc API key.", "error");
        }
    };
', \yii\web\View::POS_END);
?>