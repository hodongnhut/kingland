<div class="p-6 bg-gray-100 min-h-screen">
    <div class="flex justify-end space-x-4 mb-6">
        <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-5 rounded-md inline-flex items-center">
            <i class="fas fa-save mr-2"></i> LƯU
        </button>
        <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-5 rounded-md inline-flex items-center">
            <i class="fas fa-undo mr-2"></i> QUAY LẠI
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="flex border-b border-gray-200">
            <button
                id="tabThongTin"
                class="tab-button px-6 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600 focus:outline-none"
                data-tab="thong-tin"
            >
                <i class="fas fa-info-circle mr-2"></i> Thông Tin
            </button>
            <button
                id="tabSoHongHinhAnh"
                class="tab-button px-6 py-3 text-sm font-medium text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-300 focus:outline-none"
                data-tab="so-hong-hinh-anh"
            >
                <i class="fas fa-images mr-2"></i> Sổ Hồng & Hình Ảnh
            </button>
            </div>

        <div class="p-6">
            <div id="content-thong-tin" class="tab-content">
                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Bán Khác</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Vị Trí</label>
                                <div class="flex space-x-2">
                                    <button class="px-3 py-1 text-sm rounded-md border border-blue-500 bg-blue-500 text-white">Đường Nội Bộ</button>
                                    <button class="px-3 py-1 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">Hẻm</button>
                                    <button class="px-3 py-1 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">Compound</button>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label for="dienTich" class="block text-gray-700 text-sm font-bold mb-1">Diện Tích (m²)</label>
                                <input type="text" id="dienTich" name="dienTich" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label for="gia" class="block text-gray-700 text-sm font-bold mb-1">Giá</label>
                            <div class="flex items-center">
                                <input type="text" id="gia" name="gia" value="13.000.000.000" class="shadow-sm appearance-none border rounded-l-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <span class="bg-gray-200 text-gray-700 text-sm py-2 px-3 rounded-r-md border border-l-0 border-gray-300">TỶ</span>
                            </div>
                        </div>
                        <div>
                            <label for="giaChot" class="block text-gray-700 text-sm font-bold mb-1">Giá Chốt</label>
                            <div class="flex items-center">
                                <input type="text" id="giaChot" name="giaChot" value="0" class="shadow-sm appearance-none border rounded-l-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <span class="bg-gray-200 text-gray-700 text-sm py-2 px-3 rounded-r-md border border-l-0 border-gray-300">TỶ</span>
                            </div>
                        </div>
                        <div>
                            <label for="soThua" class="block text-gray-700 text-sm font-bold mb-1">Số Thửa</label>
                            <input type="text" id="soThua" name="soThua" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="phuongXa" class="block text-gray-700 text-sm font-bold mb-1">Phường / Xã</label>
                            <select id="phuongXa" name="phuongXa" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option>Phường 17</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Loại Tài Sản</h3>
                    <div class="flex mb-4 border-b border-gray-200">
                        <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600 focus:outline-none">Công Ty</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-300 focus:outline-none">Thừa Kế</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-300 focus:outline-none">Vợ Chồng Lý Hôn</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-300 focus:outline-none">Mất Đất</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 hover:border-b-2 hover:border-blue-300 focus:outline-none">Thế Chấp</button>
                    </div>
                    <div class="mb-4 text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i> Thông tin liên hệ chủ nhà thì hãy điền vào đây
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">HỢP ĐỒNG</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="loaiHopDong" class="block text-gray-700 text-sm font-bold mb-1">Loại Hợp Đồng</label>
                            <select id="loaiHopDong" name="loaiHopDong" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option>Tiềm Mật</option>
                                <option>Phát Triển</option>
                                <option>Tháng</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">ĐẤU THẦU</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1">Đưa Lên Đấu Thầu</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-blue-600" name="dauThau" value="co">
                                    <span class="ml-2 text-gray-700">Có</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio text-blue-600" name="dauThau" value="khong" checked>
                                    <span class="ml-2 text-gray-700">Không</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">GHI CHÚ KHÁC</h3>
                    <textarea class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-blue-500 focus:border-blue-500 h-24" placeholder="Nhập Thông Tin Mô Tả"></textarea>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Trạng Thái</h3>
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-blue-600" name="status" value="dang_giao_dich" checked>
                            <span class="ml-2 text-gray-700">Đang Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-blue-600" name="status" value="ngung_giao_dich">
                            <span class="ml-2 text-gray-700">Ngừng Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-blue-600" name="status" value="da_giao_dich">
                            <span class="ml-2 text-gray-700">Đã Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-blue-600" name="status" value="da_dat_coc">
                            <span class="ml-2 text-gray-700">Đã Đặt Cọc</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ưu Điểm</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-blue-600" name="uuDiem[]" value="can_goc">
                                <span class="ml-2 text-gray-700">Căn góc, có hầm bán hàng</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-blue-600" name="uuDiem[]" value="nha_2_mat_duong_truoc_sau">
                                <span class="ml-2 text-gray-700">Nhà 2 Mặt Đường Trước và Sau</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-blue-600" name="uuDiem[]" value="co_hem_sau_nha">
                                <span class="ml-2 text-gray-700">Có hẻm sau nhà</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-blue-600" name="uuDiem[]" value="nha_moi_xay">
                                <span class="ml-2 text-gray-700">Nhà Mới Xây</span>
                            </label>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Nhược Điểm</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-blue-600" name="nhuocDiem[]" value="dat_top_hieu">
                                <span class="ml-2 text-gray-700">Đất Tóp Hậu</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-blue-600" name="nhuocDiem[]" value="can_truoc_nha">
                                <span class="ml-2 text-gray-700">Cản Trước Nhà</span>
                            </label>
                        </div>
                    </div>
                </div>

            </div> <div id="content-so-hong-hinh-anh" class="tab-content hidden">
                <div class="mb-6 text-gray-700 text-lg font-semibold">
                    Bán Căn Hộ . Dự án
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                                <i class="fas fa-file-alt text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">SỔ HỒNG | GIẤY TỜ PHÁP LÝ</h3>
                        </div>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out">
                            <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                            <p>Chọn hoặc kéo thả</p>
                            <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                            <input type="file" multiple class="hidden">
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                                <i class="fas fa-images text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">HÌNH ẢNH BỔ SUNG</h3>
                        </div>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out">
                            <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                            <p>Chọn hoặc kéo thả</p>
                            <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                            <input type="file" multiple class="hidden">
                        </div>
                    </div>
                </div>
            </div> </div> </div> </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        function showTab(tabId) {
            tabContents.forEach(content => {
                if (content.id === `content-${tabId}`) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });

            tabButtons.forEach(button => {
                if (button.dataset.tab === tabId) {
                    button.classList.remove('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-300');
                    button.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                } else {
                    button.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                    button.classList.add('text-gray-600', 'hover:text-blue-600', 'hover:border-b-2', 'hover:border-blue-300');
                }
            });
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.dataset.tab;
                showTab(tabId);
            });
        });

        // Set initial active tab (Thông Tin)
        showTab('thong-tin');
    });
</script>