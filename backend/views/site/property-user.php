<?php
use yii\helpers\Html;
$this->title = "Quản Lý Nhân Viên";
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"> Quản Lý Nhân Viên</div>
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

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-4">

            <input type="text" placeholder="Mã Nhân viên"
                class="form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <input type="text" placeholder="Email Nhân viên"
                class="form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
          
            
            <div class="relative">
                <input type="date" placeholder="Ngày Bắt Đầu"
                    class="form-input border border-gray-300 rounded-lg p-2 pr-10 focus:ring-blue-500 focus:border-blue-500 w-full">
                <i class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            
            <!-- Ngày Kết Thúc with Calendar Icon -->
            <div class="relative">
                <input type="date" placeholder="Ngày Kết Thúc"
                    class="form-input border border-gray-300 rounded-lg p-2 pr-10 focus:ring-blue-500 focus:border-blue-500 w-full">
                <i class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>

                
            <div class="flex space-x-2">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i> TÌM
                </button>
                <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

       

    </div>

    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Số Nhà</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Đường Phố</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Phường/Xã</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quận/Huyện</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Giá</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Diện Tích</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kết Cấu</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        HĐ Thuê</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Lưu</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cập nhật</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Row 1 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>21</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>225/17</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">ĐƯỜNG NỘI BỘ</div>
                        <div>Lê Văn Sỹ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P. 1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Tân Bình</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">28 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-233 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">120 m2</div>
                        <div class="text-xs text-gray-600">(7m × 20m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 11 giờ 30</div>
                        <button class="mt-2 text-blue-600 hover:text-blue-800 text-xs flex items-center">
                            <i class="fas fa-pencil-alt mr-1"></i>
                            Sản Phẩm Mới
                        </button>
                    </td>
                </tr>
                <!-- Sample Row 2 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>22</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>185A-185B</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">MẶT TIỀN</div>
                        <div>Hà Huy Giáp</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Thạnh Lộc</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Q.12</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">90 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-191 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">471 m2</div>
                        <div class="text-xs text-gray-600">(18m × 25m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 11 giờ 30</div>
                        <button class="mt-2 text-blue-600 hover:text-blue-800 text-xs flex items-center">
                            <i class="fas fa-pencil-alt mr-1"></i>
                            Sản Phẩm Mới
                        </button>
                    </td>
                </tr>
                <!-- Sample Row 3 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>23</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">RÂN</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P. 14</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Q.3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">16.5 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-330 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">50 m2</div>
                        <div class="text-xs text-gray-600">(5.5m × 9.5m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 06 giờ 27</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4">
            <div class="flex flex-1 justify-between sm:hidden">
                <a href="#"
                    class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                <a href="#"
                    class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
            </div>
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Tổng <span class="font-medium">125.427</span> Trang <span
                            class="font-medium">2/8772</span>
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        <a href="#"
                            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <!-- Current: "z-10 bg-blue-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600", Default: "ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
                        <a href="#" aria-current="page"
                            class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">1</a>
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
                        <a href="#"
                            class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">3</a>
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                        <a href="#"
                            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>