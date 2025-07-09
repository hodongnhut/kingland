CREATE TABLE IF NOT EXISTS `departments` (
    `department_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the department',
    `department_name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Name of the department (e.g., Marketing, Sales)'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table to store company departments';

CREATE TABLE IF NOT EXISTS `job_titles` (
    `job_title_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the job title',
    `title_name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Name of the job title (e.g., Manager, Sales Staff, Administrator)',
    `role_code` VARCHAR(50) NOT NULL COMMENT 'Role identifier for access control (e.g., super_admin, sales_staff)'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table to store job titles';

CREATE TABLE IF NOT EXISTS `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Primary key for Yii2 User Identity',
    `username` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Username for login',
    `auth_key` VARCHAR(32) NOT NULL COMMENT 'Authentication key for cookie-based login (required by Yii2)',
    `password_hash` VARCHAR(255) NOT NULL COMMENT 'Hashed password for user login security (required by Yii2)',
    `password_reset_token` VARCHAR(255) UNIQUE NULL DEFAULT NULL COMMENT 'Token for password reset functionality',
    `email` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email address of the user',
    `verification_token` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Token for email verification or similar purposes',
    `full_name` VARCHAR(255) NOT NULL COMMENT 'Full name of the user',
    `phone` VARCHAR(20) NULL COMMENT 'Phone number of the user (optional)',
    `job_title_id` INT NOT NULL COMMENT 'Foreign key linking to the job_titles table',
    `department_id` INT NULL COMMENT 'Foreign key linking to the departments table (optional)',
    `status` SMALLINT NOT NULL DEFAULT 10 COMMENT 'Current status of the user (e.g., 9: Inactive, 10: Active)',
    `created_at` INT(11) NOT NULL COMMENT 'Unix timestamp when the record was created',
    `updated_at` INT(11) NOT NULL COMMENT 'Unix timestamp of the last update to the record',

-- Foreign key constraints
CONSTRAINT `fk_user_job_title`
        FOREIGN KEY (`job_title_id`)
        REFERENCES `job_titles` (`job_title_id`)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_user_department`
        FOREIGN KEY (`department_id`)
        REFERENCES `departments` (`department_id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table to store user details, compatible with Yii2 User Identity';

INSERT INTO
    `job_titles` (`title_name`, `role_code`)
VALUES ('Quản lý', 'manager'),
    (
        'Nhân viên kinh doanh',
        'sales_staff'
    ),
    (
        'Hỗ trợ kỹ thuật',
        'tech_support'
    ),
    (
        'Quản trị viên',
        'super_admin'
    ),
    ('Kế toán', 'accountant');

INSERT INTO
    `departments` (`department_name`)
VALUES ('Phòng Marketing'),
    ('Phòng Kinh doanh'),
    ('Phòng Kỹ thuật'),
    ('Phòng Hành chính - Nhân sự'),
    ('Phòng Kế toán');

INSERT INTO
    `user` (
        `username`,
        `auth_key`,
        `password_hash`,
        `email`,
        `full_name`,
        `phone`,
        `job_title_id`,
        `department_id`,
        `status`,
        `created_at`,
        `updated_at`
    )
VALUES (
        'john_doe2',
        'random32charstring1234567890abcd',
        '$2y$13$examplehashedpassword...', -- Replace with actual hashed password
        'john.doe2@example.com',
        'John Doe',
        '1234567890',
        2, -- Assuming job_title_id = 1 for 'Quản lý'
        2, -- Assuming department_id = 2 for 'Phòng Kinh doanh'
        10, -- Active status
        UNIX_TIMESTAMP(),
        UNIX_TIMESTAMP()
    );

CREATE TABLE IF NOT EXISTS `property_types` (
    `property_type_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the property type',
    `type_name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Name of the property type'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for property types';

CREATE TABLE IF NOT EXISTS `location_types` (
    `location_type_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the location type',
    `type_name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Name of the location type'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for property location types (e.g., alley, compound)';

CREATE TABLE IF NOT EXISTS `asset_types` (
    `asset_type_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the asset type',
    `type_name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Name of the asset type'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for asset ownership/origin types';

CREATE TABLE IF NOT EXISTS `transaction_statuses` (
    `transaction_status_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the transaction status',
    `status_name` VARCHAR(100) NOT NULL UNIQUE COMMENT 'Name of the transaction status'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for property transaction statuses';

CREATE TABLE IF NOT EXISTS `advantages` (
    `advantage_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the advantage',
    `advantage_name` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Description of the advantage (e.g., Nhà Mới Xây, Gần Chợ)'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for property advantages';

CREATE TABLE IF NOT EXISTS `disadvantages` (
    `disadvantage_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the disadvantage',
    `disadvantage_name` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Description of the disadvantage (e.g., Đất Bị Quy Hoạch, Có Trụ Điện)'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for property disadvantages';

CREATE TABLE IF NOT EXISTS `properties` (
    `property_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the property',
    `user_id` INT NOT NULL COMMENT 'Foreign key to the user table (who manages/created this property)',
    `title` VARCHAR(500) NULL COMMENT 'General title for the property listing',
    `property_type_id` INT NULL COMMENT 'Foreign key to property_types table (e.g., Nhà phố, Đất)',
    `selling_price` DECIMAL(18, 2) NULL COMMENT 'Selling price of the property',
    `has_vat_invoice` TINYINT(1) DEFAULT 0 COMMENT 'Indicates if the property comes with a VAT invoice (0=No, 1=Yes)',
    `house_number` VARCHAR(50) NULL COMMENT 'House number of the property',
    `street_name` VARCHAR(255) NULL COMMENT 'Street name of the property',
    `ward_commune` VARCHAR(100) NULL COMMENT 'Ward/Commune of the property',
    `district_county` VARCHAR(100) NULL COMMENT 'District/County of the property',
    `city` VARCHAR(100) DEFAULT 'Hồ Chí Minh' COMMENT 'City of the property',
    `location_type_id` INT NULL COMMENT 'Foreign key to location_types (e.g., Đường Nội Bộ, Mặt tiền)',
    `alley_details` TEXT NULL COMMENT 'Details about the alley access, if applicable',
    `compound_name` VARCHAR(255) NULL COMMENT 'Name of the compound, if applicable',
    `area_width` DECIMAL(10, 2) NULL COMMENT 'Width of the property area in meters',
    `area_length` DECIMAL(10, 2) NULL COMMENT 'Length of the property area in meters',
    `area_total` DECIMAL(10, 2) NULL COMMENT 'Total area of the property in square meters',
    `planned_width` DECIMAL(10, 2) NULL COMMENT 'Planned width of the property in meters (quy hoạch)',
    `planned_length` DECIMAL(10, 2) NULL COMMENT 'Planned length of the property in meters (quy hoạch)',
    `planned_construction_area` DECIMAL(10, 2) NULL COMMENT 'Planned construction area in square meters (quy hoạch)',
    `usable_area` DECIMAL(10, 2) NULL COMMENT 'Usable area of the property in square meters',
    `direction` VARCHAR(50) NULL COMMENT 'Direction/facing of the property (e.g., Đông, Tây, Nam, Bắc)',
    `land_type` VARCHAR(50) NULL COMMENT 'Type of land (e.g., Đất ở, Đất nông nghiệp)',
    `num_toilets` TINYINT NULL COMMENT 'Number of toilets',
    `num_bedrooms` TINYINT NULL COMMENT 'Number of bedrooms',
    `num_basements` TINYINT NULL COMMENT 'Number of basements',
    `asset_type_id` INT NULL COMMENT 'Foreign key to asset_types (e.g., Cá nhân, Công ty, Đấu giá)',
    `description` TEXT NULL COMMENT 'Detailed description of the property',
    `commission_type` ENUM('fixed_amount', 'percentage') NULL COMMENT 'Type of commission (fixed_amount or percentage)',
    `commission_value` DECIMAL(10, 2) NULL COMMENT 'Value of the commission',
    `commission_unit` VARCHAR(50) NULL COMMENT 'Unit of commission (e.g., VNĐ, %)',
    `has_deposit` TINYINT(1) DEFAULT 0 COMMENT 'Indicates if a deposit has been placed (0=No, 1=Yes)',
    `transaction_status_id` INT NULL COMMENT 'Foreign key to transaction_statuses (e.g., Đang Giao Dịch, Ngừng Giao Dịch)',
    `transaction_description` TEXT NULL COMMENT 'Additional description for transaction status',
    `has_rental_contract` TINYINT(1) DEFAULT 0 COMMENT 'Indicates if the property has a rental contract (0=No, 1=Yes)',
    `is_active` TINYINT(1) DEFAULT 1 COMMENT 'General listing status (0=Inactive, 1=Active)',
    `created_at` INT(11) NOT NULL COMMENT 'Unix timestamp when the record was created',
    `updated_at` INT(11) NOT NULL COMMENT 'Unix timestamp of the last update to the record',

-- Foreign key constraints
CONSTRAINT `fk_property_user`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_property_type`
        FOREIGN KEY (`property_type_id`)
        REFERENCES `property_types` (`property_type_id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_property_location_type`
        FOREIGN KEY (`location_type_id`)
        REFERENCES `location_types` (`location_type_id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_property_asset_type`
        FOREIGN KEY (`asset_type_id`)
        REFERENCES `asset_types` (`asset_type_id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_property_transaction_status`
        FOREIGN KEY (`transaction_status_id`)
        REFERENCES `transaction_statuses` (`transaction_status_id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Main table for property listings';

-- -----------------------------------------------------
-- Junction Table `property_advantages`
-- Many-to-many relationship between properties and advantages.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_advantages` (
    `property_id` INT NOT NULL COMMENT 'Foreign key to the properties table',
    `advantage_id` INT NOT NULL COMMENT 'Foreign key to the advantages table',
    PRIMARY KEY (`property_id`, `advantage_id`),
    CONSTRAINT `fk_pa_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_pa_advantage` FOREIGN KEY (`advantage_id`) REFERENCES `advantages` (`advantage_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Junction table for property advantages';

-- -----------------------------------------------------
-- Junction Table `property_disadvantages`
-- Many-to-many relationship between properties and disadvantages.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_disadvantages` (
    `property_id` INT NOT NULL COMMENT 'Foreign key to the properties table',
    `disadvantage_id` INT NOT NULL COMMENT 'Foreign key to the disadvantages table',
    PRIMARY KEY (
        `property_id`,
        `disadvantage_id`
    ),
    CONSTRAINT `fk_pd_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_pd_disadvantage` FOREIGN KEY (`disadvantage_id`) REFERENCES `disadvantages` (`disadvantage_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Junction table for property disadvantages';

-- -----------------------------------------------------
-- Table `property_images`
-- Stores image paths/URLs for each property.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_images` (
    `image_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the image',
    `property_id` INT NOT NULL COMMENT 'Foreign key to the properties table',
    `image_path` VARCHAR(255) NOT NULL COMMENT 'Path or URL to the image file',
    `is_main` TINYINT(1) DEFAULT 0 COMMENT 'Indicates if this is the main image (0=No, 1=Yes)',
    `sort_order` INT DEFAULT 0 COMMENT 'Order for displaying images',
    `created_at` INT(11) NOT NULL COMMENT 'Unix timestamp when the record was created',
    `updated_at` INT(11) NOT NULL COMMENT 'Unix timestamp of the last update to the record',
    CONSTRAINT `fk_pi_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for property images';

-- -----------------------------------------------------
-- Table `property_documents`
-- Stores document paths/URLs (e.g., sổ hồng, sổ tờ) for each property.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_documents` (
    `document_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the document',
    `property_id` INT NOT NULL COMMENT 'Foreign key to the properties table',
    `document_path` VARCHAR(255) NOT NULL COMMENT 'Path or URL to the document file',
    `document_type` VARCHAR(100) NULL COMMENT 'Type of document (e.g., "Sổ hồng", "Sổ tờ", "Hợp đồng thuê")',
    `created_at` INT(11) NOT NULL COMMENT 'Unix timestamp when the record was created',
    `updated_at` INT(11) NOT NULL COMMENT 'Unix timestamp of the last update to the record',
    CONSTRAINT `fk_pd_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for property related documents';

-- -----------------------------------------------------
-- Table `activity_log`
-- Records user activities related to properties and other system interactions.
-- This can power the "Top Hoạt Động Trong 7 ngày qua" chart.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `activity_log` (
    `log_id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the log entry',
    `user_id` INT NULL COMMENT 'Foreign key to the user table (who performed the action). NULL if system action.',
    `action_type` VARCHAR(100) NOT NULL COMMENT 'Type of action (e.g., "Thêm mới", "Xem số điện thoại", "Bổ sung thông tin nhà", "Tải File", "Xem trang")',
    `entity_type` VARCHAR(100) NULL COMMENT 'Type of entity involved (e.g., "Property", "User")',
    `entity_id` INT NULL COMMENT 'ID of the entity involved (e.g., property_id)',
    `description` TEXT NULL COMMENT 'Detailed description of the action',
    `ip_address` VARCHAR(45) NULL COMMENT 'IP address from which the action was performed',
    `user_agent` TEXT NULL COMMENT 'User agent string of the client',
    `created_at` INT(11) NOT NULL COMMENT 'Unix timestamp when the activity occurred'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table for system activity logs';

-- -----------------------------------------------------
-- Optional: Initial data for lookup tables
-- -----------------------------------------------------

INSERT INTO
    `property_types` (`type_name`)
VALUES ('Nhà phố'),
    ('Biệt thự'),
    ('Đất nền'),
    ('Chung cư'),
    ('Căn hộ'),
    ('Shophouse');

INSERT INTO
    `location_types` (`type_name`)
VALUES ('Mặt tiền'),
    ('Hẻm'),
    ('Hẻm xe hơi'),
    ('Đường Nội Bộ'),
    ('Compound');

INSERT INTO
    `asset_types` (`type_name`)
VALUES ('Cá nhân'),
    ('Công ty'),
    ('Thừa kế'),
    ('Vợ Chồng Ly Hôn'),
    ('Phát mãi'),
    ('Đấu giá'),
    ('Thế Chấp');

INSERT INTO
    `transaction_statuses` (`status_name`)
VALUES ('Đang Giao Dịch'),
    ('Ngừng Giao Dịch'),
    ('Đã Giao Dịch'),
    ('Đã Đặt Cọc'),
    ('Sản Phẩm Mới');

INSERT INTO
    `advantages` (`advantage_name`)
VALUES ('Nhà Mới Xây'),
    ('Gần Chợ'),
    ('Ba Mở Lớn'),
    ('Nhà Kế Bên Có Biệt Thự'),
    ('Vị Trí Đẹp Nhất'),
    ('Lô Góc'),
    ('Gần Lộ Giới'),
    (
        'Nhà 2 Mặt Đường Trước và Sau'
    ),
    ('Có Hẻm Sau Nhà'),
    ('Hẻm Thông'),
    ('Gần Công Viên'),
    ('Nhà Thờ Cấp Ba'),
    ('Nhà Thiết Kế Đẹp'),
    ('Quy Hoạch Mở Đường'),
    ('Quy Hoạch Đất Ở'),
    ('Dân Cư Đông Đúc'),
    ('Gần Trường Học'),
    ('Chợ Lớn'),
    ('Đường Lớn'),
    ('Gần Biển'),
    ('Nhà Bề Thế'),
    ('Nhà Cho Thuê');

INSERT INTO
    `disadvantages` (`disadvantage_name`)
VALUES ('Đất Bị Quy Hoạch'),
    ('Đất Không Được Vườn'),
    ('Có Công Trình'),
    ('Có Trụ Điện'),
    ('Có Cây To'),
    ('Đất Cho Hẻm Thông'),
    ('Quy Hoạch Giao Thông'),
    ('Quy Hoạch Lô Giới Hạn'),
    ('Pháp Lý Không Rõ Ràng'),
    ('Đất Dính Quy Hoạch'),
    ('Gần Nghĩa Trang'),
    ('Gần Nhà Táng'),
    ('Đất Khó Kiếm');

property_access_logs (
    id INT PRIMARY KEY,
    user_id INT,
    property_id INT,
    accessed_at DATETIME
)

CREATE TABLE IF NOT EXISTS `devices` (
    `id` INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Unique identifier for the device',
    `device_name` VARCHAR(255) NOT NULL COMMENT 'Name of the device (e.g., Máy Tính, Điện thoại)',
    `os` VARCHAR(100) NULL COMMENT 'Operating System (e.g., Linux, Android)',
    `device_unique_id` VARCHAR(255) UNIQUE NULL COMMENT 'Unique hardware ID or identifier for the device',
    `browser` VARCHAR(100) NULL COMMENT 'Browser used (e.g., Chrome, Firefox)',
    `last_activity_at` INT(11) NULL COMMENT 'Unix timestamp of the last activity on this device',
    `last_action_type` VARCHAR(100) NULL COMMENT 'Type of the last action (e.g., Login, View, Search)',
    `first_login_at` INT(11) NULL COMMENT 'Unix timestamp of the first login from this device',
    `session_info` VARCHAR(255) NULL COMMENT 'Information about the current session (e.g., session ID, specific data)',
    `user_id` INT NOT NULL COMMENT 'Foreign key to the user table, indicating who logged in from this device',
    `is_current_device` TINYINT(1) DEFAULT 0 COMMENT 'Flag to indicate if this is the currently active device for the user',
    `created_at` INT(11) NOT NULL COMMENT 'Unix timestamp when the device record was created',
    `updated_at` INT(11) NOT NULL COMMENT 'Unix timestamp of the last update to the record',
    CONSTRAINT `fk_device_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT 'Table to store user device information';

CREATE TABLE user_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    latitude DOUBLE NOT NULL,
    longitude DOUBLE NOT NULL,
    device_type VARCHAR(50), -- Loại thiết bị (ví dụ: 'Máy Tính', 'Điện thoại')
    os VARCHAR(50), -- Hệ điều hành của thiết bị (ví dụ: 'Linux', 'Android')
    browser VARCHAR(50), -- Trình duyệt được sử dụng (ví dụ: 'Chrome', 'Firefox')
    device_unique_id VARCHAR(255), -- Mã định danh duy nhất của thiết bị
    session_id VARCHAR(255), -- ID phiên hoạt động hiện tại
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_locations_user FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL UNIQUE, -- Tên nhóm bản tin, ví dụ: "Thông báo", "Tin tức", "Sự kiện"
    description TEXT -- Mô tả thêm về nhóm (có thể NULL)
);

CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL, -- Khóa ngoại liên kết với bảng categories
    post_title VARCHAR(255) NOT NULL, -- Tiêu đề của bản tin
    post_content TEXT, -- Nội dung chi tiết của bản tin (có thể NULL nếu nội dung được lưu trữ riêng biệt hoặc không hiển thị trên danh sách)
    post_type ENUM('DOC', 'NEWS', 'EVENT') NOT NULL, -- Loại bản tin dựa trên icon
    post_date DATE NOT NULL, -- Ngày đăng bản tin
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Thời gian tạo bản ghi
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Thời gian cập nhật bản ghi
    is_active BOOLEAN DEFAULT TRUE, -- Trạng thái kích hoạt của bản tin (có thể dùng để ẩn/hiện)
    FOREIGN KEY (category_id) REFERENCES categories (category_id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE attachments (
    attachment_id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50),
    file_size INT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts (post_id) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO
    categories (category_name)
VALUES ('Thông báo'),
    ('Tin tức'),
    ('Sự kiện');

INSERT INTO
    posts (
        category_id,
        post_title,
        post_type,
        post_date,
        post_content
    )
VALUES (
        1,
        'THÔNG BÁO THAY ĐỔI THỜI GIAN LÀM VIỆC',
        'DOC',
        '2024-04-02',
        'Nội dung chi tiết thông báo thay đổi thời gian làm việc...'
    ),
    (
        2,
        'CẬP NHẬT CHÍNH SÁCH HOA HỒNG MỚI NĂM 2024',
        'NEWS',
        '2024-03-28',
        'Nội dung chi tiết cập nhật chính sách hoa hồng...'
    ),
    (
        3,
        'THÔNG BÁO TỔ CHỨC TIỆC TẤT NIÊN CÔNG TY',
        'EVENT',
        '2024-03-15',
        'Nội dung chi tiết thông báo tiệc tất niên...'
    );

-- Creating table structure for provinces
CREATE TABLE Provinces (
    id INT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Keyword VARCHAR(50),
    latlng VARCHAR(50),
    Lookup VARCHAR(100)
);

);

-- Inserting data into Provinces table
INSERT INTO
    Provinces (
        id,
        Name,
        Keyword,
        latlng,
        Lookup
    )
VALUES (
        0,
        'Chọn Tỉnh Thành',
        NULL,
        NULL,
        NULL
    ),
    (
        57,
        'An Giang',
        'an-giang',
        '10.5392057,105.2312822',
        'An Giang AnGiang'
    ),
    (
        49,
        'Bà Rịa - Vũng Tàu',
        'ba-ria---vung-tau',
        '10.5738801,107.3284362',
        'Ba Ria - Vung Tau BaRia-VungTau'
    ),
    (
        47,
        'Bình Dương',
        'binh-duong',
        '11.1836551,106.7031737',
        'Binh Duong BinhDuong'
    ),
    (
        45,
        'Bình Phước',
        'binh-phuoc',
        '11.7543232,106.9266473',
        'Binh Phuoc BinhPhuoc'
    ),
    (
        39,
        'Bình Thuận',
        'binh-thuan',
        '11.1041572,108.1832931',
        'Binh Thuan BinhThuan'
    ),
    (
        35,
        'Bình Định',
        'binh-dinh',
        '14.0779378,108.9898798',
        'Binh Dinh BinhDinh'
    ),
    (
        62,
        'Bạc Liêu',
        'bac-lieu',
        '9.3298341,105.5099460',
        'Bac Lieu BacLieu'
    ),
    (
        15,
        'Bắc Giang',
        'bac-giang',
        '21.3169625,106.4379850',
        'Bac Giang BacGiang'
    ),
    (
        4,
        'Bắc Kạn',
        'bac-kan',
        '22.2571701,105.8204437',
        'Bac Kan BacKan'
    ),
    (
        18,
        'Bắc Ninh',
        'bac-ninh',
        '21.0955822,106.1264766',
        'Bac Ninh BacNinh'
    ),
    (
        53,
        'Bến Tre',
        'ben-tre',
        '10.1093637,106.4811559',
        'Ben Tre BenTre'
    ),
    (
        3,
        'Cao Bằng',
        'cao-bang',
        '22.7426936,106.1060926',
        'Cao Bang CaoBang'
    ),
    (
        63,
        'Cà Mau',
        'ca-mau',
        '9.0180177,105.0869724',
        'Ca Mau CaMau'
    ),
    (
        59,
        'Cần Thơ',
        'can-tho',
        '10.0364634,105.7875821',
        'Can Tho CanTho'
    ),
    (
        41,
        'Gia Lai',
        'gia-lai',
        '13.8177445,108.2004015',
        'Gia Lai GiaLai'
    ),
    (
        2,
        'Hà Giang',
        'ha-giang',
        '22.7336097,105.0027271',
        'Ha Giang HaGiang'
    ),
    (
        23,
        'Hà Nam',
        'ha-nam',
        '20.5340294,105.9810248',
        'Ha Nam HaNam'
    ),
    (
        1,
        'Hà Nội',
        'ha-noi',
        '21.0283334,105.8540410',
        'Ha Noi HaNoi'
    ),
    (
        28,
        'Hà Tĩnh',
        'ha-tinh',
        '18.3504832,105.7623047',
        'Ha Tinh HaTinh'
    ),
    (
        19,
        'Hải Dương',
        'hai-duong',
        '20.8930571,106.3725441',
        'Hai Duong HaiDuong'
    ),
    (
        20,
        'Hải Phòng',
        'hai-phong',
        '20.8588640,106.6749591',
        'Hai Phong HaiPhong'
    ),
    (
        60,
        'Hậu Giang',
        'hau-giang',
        '9.7985063,105.6379524',
        'Hau Giang HauGiang'
    ),
    (
        50,
        'Hồ Chí Minh',
        'ho-chi-minh',
        '10.7763897,106.7011391',
        'Ho Chi Minh HoChiMinh'
    ),
    (
        11,
        'Hoà Bình',
        'hoa-binh',
        '20.6763365,105.3759952',
        'Hoa Binh HoaBinh'
    ),
    (
        21,
        'Hưng Yên',
        'hung-yen',
        '20.7833912,106.0699025',
        'Hung Yen HungYen'
    ),
    (
        37,
        'Khánh Hòa',
        'khanh-hoa',
        '12.2980751,108.9950386',
        'Khanh Hoa KhanhHoa'
    ),
    (
        58,
        'Kiên Giang',
        'kien-giang',
        '9.9904962,105.2435248',
        'Kien Giang KienGiang'
    ),
    (
        40,
        'Kon Tum',
        'kon-tum',
        '14.6995372,107.9323831',
        'Kon Tum KonTum'
    ),
    (
        8,
        'Lai Châu',
        'lai-chau',
        '22.2921668,103.1798662',
        'Lai Chau LaiChau'
    ),
    (
        6,
        'Lào Cai',
        'lao-cai',
        '22.3069302,104.1829592',
        'Lao Cai LaoCai'
    ),
    (
        44,
        'Lâm Đồng',
        'lam-dong',
        '11.6614957,108.1335279',
        'Lam Dong LamDong'
    ),
    (
        13,
        'Lạng Sơn',
        'lang-son',
        '21.8487579,106.6140692',
        'Lang Son LangSon'
    ),
    (
        51,
        'Long An',
        'long-an',
        '10.6983968,106.1883517',
        'Long An LongAn'
    ),
    (
        24,
        'Nam Định',
        'nam-dinh',
        '20.2686476,106.2289075',
        'Nam Dinh NamDinh'
    ),
    (
        27,
        'Nghệ An',
        'nghe-an',
        '19.1976001,105.0606760',
        'Nghe An NgheAn'
    ),
    (
        25,
        'Ninh Bình',
        'ninh-binh',
        '20.2051051,105.9280678',
        'Ninh Binh NinhBinh'
    ),
    (
        38,
        'Ninh Thuận',
        'ninh-thuan',
        '11.6965639,108.8928476',
        'Ninh Thuan NinhThuan'
    ),
    (
        16,
        'Phú Thọ',
        'phu-tho',
        '21.3007538,105.1349604',
        'Phu Tho PhuTho'
    ),
    (
        36,
        'Phú Yên',
        'phu-yen',
        '13.1912633,109.1273678',
        'Phu Yen PhuYen'
    ),
    (
        29,
        'Quảng Bình',
        'quang-binh',
        '17.5095990,106.4004452',
        'Quang Binh QuangBinh'
    ),
    (
        33,
        'Quảng Nam',
        'quang-nam',
        '15.5761698,108.0527132',
        'Quang Nam QuangNam'
    ),
    (
        34,
        'Quảng Ngãi',
        'quang-ngai',
        '14.9953739,108.6917290',
        'Quang Ngai QuangNgai'
    ),
    (
        14,
        'Quảng Ninh',
        'quang-ninh',
        '21.1718046,107.2012742',
        'Quang Ninh QuangNinh'
    ),
    (
        30,
        'Quảng Trị',
        'quang-tri',
        '16.7897806,106.9797431',
        'Quang Tri QuangTri'
    ),
    (
        61,
        'Sóc Trăng',
        'soc-trang',
        '9.5628369,105.9493991',
        'Soc Trang SocTrang'
    ),
    (
        9,
        'Sơn La',
        'son-la',
        '21.2276769,104.1575944',
        'Son La SonLa'
    ),
    (
        46,
        'Tây Ninh',
        'tay-ninh',
        '11.4019366,106.1626927',
        'Tay Ninh TayNinh'
    ),
    (
        26,
        'Thanh Hóa',
        'thanh-hoa',
        '19.9781573,105.4816107',
        'Thanh Hoa ThanhHoa'
    ),
    (
        22,
        'Thái Bình',
        'thai-binh',
        '20.5296832,106.3876068',
        'Thai Binh ThaiBinh'
    ),
    (
        12,
        'Thái Nguyên',
        'thai-nguyen',
        '21.6498502,105.8351394',
        'Thai Nguyen ThaiNguyen'
    ),
    (
        31,
        'Thừa Thiên Huế',
        'thua-thien-hue',
        '16.3480798,107.5398913',
        'Thua Thien Hue ThuaThienHue'
    ),
    (
        52,
        'Tiền Giang',
        'tien-giang',
        '10.4030368,106.3616330',
        'Tien Giang TienGiang'
    ),
    (
        54,
        'Trà Vinh',
        'tra-vinh',
        '9.8037998,106.3256808',
        'Tra Vinh TraVinh'
    ),
    (
        5,
        'Tuyên Quang',
        'tuyen-quang',
        '22.0747798,105.2584110',
        'Tuyen Quang TuyenQuang'
    ),
    (
        55,
        'Vĩnh Long',
        'vinh-long',
        '10.1203043,106.0125705',
        'Vinh Long VinhLong'
    ),
    (
        17,
        'Vĩnh Phúc',
        'vinh-phuc',
        '21.3778689,105.5758286',
        'Vinh Phuc VinhPhuc'
    ),
    (
        10,
        'Yên Bái',
        'yen-bai',
        '21.8268679,104.6631220',
        'Yen Bai YenBai'
    ),
    (
        32,
        'Đà Nẵng',
        'da-nang',
        '16.0680000,108.2120000',
        'Da Nang DaNang'
    ),
    (
        42,
        'Đắk Lắk',
        'dak-lak',
        '12.8292274,108.2999058',
        'Dak Lak DakLak'
    ),
    (
        43,
        'Đắk Nông',
        'dak-nong',
        '12.2818851,107.7302484',
        'Dak Nong DakNong'
    ),
    (
        48,
        'Đồng Nai',
        'dong-nai',
        '11.0355624,107.1881076',
        'Dong Nai DongNai'
    ),
    (
        56,
        'Đồng Tháp',
        'dong-thap',
        '10.5904240,105.6802341',
        'Dong Thap DongThap'
    ),
    (
        7,
        'Điện Biên',
        'dien-bien',
        '21.6546566,103.2168632',
        'Dien Bien DienBien'
    );

CREATE TABLE Districts (
    id INT PRIMARY KEY,
    TCTKid VARCHAR(10),
    Name VARCHAR(100) NOT NULL,
    ProvinceId VARCHAR(10),
    Prefix VARCHAR(20),
    Keyword VARCHAR(50),
    latlng VARCHAR(50),
    Lookup VARCHAR(100)
);

INSERT INTO
    Districts (
        id,
        TCTKid,
        Name,
        ProvinceId,
        Prefix,
        Keyword,
        latlng,
        Lookup
    )
VALUES (
        0,
        NULL,
        'Chọn Quận/Huyện',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL
    ),
    (
        550,
        '760',
        'Quận 1',
        '50',
        'Quận',
        '1',
        '10.7773145,106.6999907',
        '1 1'
    ),
    (
        559,
        '771',
        'Quận 10',
        '50',
        'Quận',
        '10',
        '10.7727320,106.6683666',
        '10 10'
    ),
    (
        560,
        '772',
        'Quận 11',
        '50',
        'Quận',
        '11',
        '10.7658124,106.6474946',
        '11 11'
    ),
    (
        551,
        '761',
        'Quận 12',
        '50',
        'Quận',
        '12',
        '10.8616036,106.6609731',
        '12 12'
    ),
    (
        558,
        '770',
        'Quận 3',
        '50',
        'Quận',
        '3',
        '10.7786390,106.6870156',
        '3 3'
    ),
    (
        561,
        '773',
        'Quận 4',
        '50',
        'Quận',
        '4',
        '10.7607328,106.7075519',
        '4 4'
    ),
    (
        562,
        '774',
        'Quận 5',
        '50',
        'Quận',
        '5',
        '10.7553616,106.6685441',
        '5 5'
    ),
    (
        563,
        '775',
        'Quận 6',
        '50',
        'Quận',
        '6',
        '10.7458860,106.6392921',
        '6 6'
    ),
    (
        566,
        '778',
        'Quận 7',
        '50',
        'Quận',
        '7',
        '10.7375481,106.7302238',
        '7 7'
    ),
    (
        564,
        '776',
        'Quận 8',
        '50',
        'Quận',
        '8',
        '10.7217236,106.6296151',
        '8 8'
    ),
    (
        569,
        '785',
        'Huyện Bình Chánh',
        '50',
        'Huyện',
        'binh-chanh',
        '10.7500035,106.5148858',
        'binh chanh binhchanh'
    ),
    (
        565,
        '777',
        'Quận Bình Tân',
        '50',
        'Quận',
        'binh-tan',
        '10.7703708,106.5996353',
        'binh tan binhtan'
    ),
    (
        553,
        '765',
        'Quận Bình Thạnh',
        '50',
        'Quận',
        'binh-thanh',
        '10.8117887,106.7039109',
        'binh thanh binhthanh'
    ),
    (
        571,
        '787',
        'Huyện Cần Giờ',
        '50',
        'Huyện',
        'can-gio',
        '10.5265318,106.8821244',
        'can gio cangio'
    ),
    (
        567,
        '783',
        'Huyện Củ Chi',
        '50',
        'Huyện',
        'cu-chi',
        '11.0370567,106.5024104',
        'cu chi cuchi'
    ),
    (
        552,
        '764',
        'Quận Gò Vấp',
        '50',
        'Quận',
        'go-vap',
        '10.8345635,106.6739598',
        'go vap govap'
    ),
    (
        568,
        '784',
        'Huyện Hóc Môn',
        '50',
        'Huyện',
        'hoc-mon',
        '10.8783450,106.5763531',
        'hoc mon hocmon'
    ),
    (
        570,
        '786',
        'Huyện Nhà Bè',
        '50',
        'Huyện',
        'nha-be',
        '10.6509670,106.7263825',
        'nha be nhabe'
    ),
    (
        556,
        '768',
        'Quận Phú Nhuận',
        '50',
        'Quận',
        'phu-nhuan',
        '10.8009810,106.6794379',
        'phu nhuan phunhuan'
    ),
    (
        554,
        '766',
        'Quận Tân Bình',
        '50',
        'Quận',
        'tan-binh',
        '10.8025830,106.6521157',
        'tan binh tanbinh'
    ),
    (
        555,
        '767',
        'Quận Tân Phú',
        '50',
        'Quận',
        'tan-phu',
        '10.7914967,106.6278431',
        'tan phu tanphu'
    ),
    (
        557,
        '769',
        'Thành phố Thủ Đức',
        '50',
        'Thành phố',
        'thu-duc',
        '10.8298295,106.7617899',
        'thu duc thuduc'
    );

CREATE TABLE Wards (
    id INT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    ProvinceId VARCHAR(10),
    DistrictId VARCHAR(10),
    Prefix VARCHAR(50),
    Keyword VARCHAR(100),
    latlng VARCHAR(50),
    Lookup VARCHAR(150)
);

CREATE TABLE Streets (
    id INT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Name_vi_Old VARCHAR(100),
    Keyword_Old VARCHAR(100),
    ProvinceId VARCHAR(10),
    DistrictId VARCHAR(10),
    Prefix VARCHAR(50),
    Keyword VARCHAR(100),
    Lookup VARCHAR(150)
);

INSERT INTO
    Wards (
        id,
        Name,
        ProvinceId,
        DistrictId,
        Prefix,
        Keyword,
        latlng,
        Lookup
    )
VALUES (
        0,
        'Chọn Quận/Huyện',
        NULL,
        NULL,
        NULL,
        '',
        NULL,
        ''
    ),
    (
        8689,
        'Phường Bến Nghé',
        '50',
        '550',
        'Phường',
        'ben-nghe',
        '10.7801495,106.7032527',
        'ben nghe bennghe'
    ),
    (
        8690,
        'Phường Bến Thành',
        '50',
        '550',
        'Phường',
        'ben-thanh',
        '10.7737414,106.6941118',
        'ben thanh benthanh'
    ),
    (
        8694,
        'Phường Cô Giang',
        '50',
        '550',
        'Phường',
        'co-giang',
        '10.7622107,106.6934252',
        'co giang cogiang'
    ),
    (
        8693,
        'Phường Cầu Ông Lãnh',
        '50',
        '550',
        'Phường',
        'cau-ong-lanh',
        '10.7654571,106.6967082',
        'cau ong lanh cauonglanh'
    ),
    (
        8696,
        'Phường Cầu Kho',
        '50',
        '550',
        'Phường',
        'cau-kho',
        '10.7581211,106.6890049',
        'cau kho caukho'
    ),
    (
        8695,
        'Phường Nguyễn Cư Trinh',
        '50',
        '550',
        'Phường',
        'nguyen-cu-trinh',
        '10.7630751,106.6863012',
        'nguyen cu trinh nguyencutrinh'
    ),
    (
        8691,
        'Phường Nguyễn Thái Bình',
        '50',
        '550',
        'Phường',
        'nguyen-thai-binh',
        '10.7686402,106.7005920',
        'nguyen thai binh nguyenthaibinh'
    ),
    (
        8692,
        'Phường Phạm Ngũ Lão',
        '50',
        '550',
        'Phường',
        'pham-ngu-lao',
        '10.7673332,106.6905498',
        'pham ngu lao phamngulao'
    ),
    (
        8687,
        'Phường Tân Định',
        '50',
        '550',
        'Phường',
        'tan-dinh',
        '10.7925016,106.6907644',
        'tan dinh tandinh'
    ),
    (
        8688,
        'Phường Đa Kao',
        '50',
        '550',
        'Phường',
        'da-kao',
        '10.7888339,106.6987037',
        'da kao dakao'
    );

-- Inserting data into Streets table
INSERT INTO
    Streets (
        id,
        Name,
        Name_vi_Old,
        Keyword_Old,
        ProvinceId,
        DistrictId,
        Prefix,
        Keyword,
        Lookup
    )
VALUES (
        0,
        'Chọn Đường',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        '',
        ''
    ),
    (
        3021,
        'Đường 15B',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        '15b',
        '15b 15b'
    ),
    (
        3022,
        'Đường 3A',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        '3a',
        '3a 3a'
    ),
    (
        3023,
        'Đường Alexandre',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'alexandre',
        'alexandre alexandre'
    ),
    (
        3024,
        'Đường Bà Huyện Thanh Quan',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ba-huyen-thanh-quan',
        'ba huyen thanh quan bahuyenthanhquan'
    ),
    (
        3025,
        'Đường Bà Lê Chân',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ba-le-chan',
        'ba le chan balechan'
    ),
    (
        3027,
        'Đường Bùi Thị Xuân',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'bui-thi-xuan',
        'bui thi xuan buithixuan'
    ),
    (
        3028,
        'Đường Bùi Viện',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'bui-vien',
        'bui vien buivien'
    ),
    (
        3026,
        'Đường Bến Chương Dương',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ben-chuong-duong',
        'ben chuong duong benchuongduong'
    ),
    (
        3030,
        'Đường Calmette',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'calmette',
        'calmette calmette'
    ),
    (
        3031,
        'Đường Camex',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'camex',
        'camex camex'
    ),
    (
        3032,
        'Đường Cao Bá Nhạ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cao-ba-nha',
        'cao ba nha caobanha'
    ),
    (
        3033,
        'Đường Cao Bá Quát',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cao-ba-quat',
        'cao ba quat caobaquat'
    ),
    (
        3029,
        'Đường Cách Mạng Tháng Tám',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cach-mang-thang-tam',
        'cach mang thang tam cachmangthangtam'
    ),
    (
        3034,
        'Đường Cây Điệp',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cay-diep',
        'cay diep caydiep'
    ),
    (
        3036,
        'Đường Cô Bắc',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'co-bac',
        'co bac cobac'
    ),
    (
        3037,
        'Đường Cô Giang',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'co-giang',
        'co giang cogiang'
    ),
    (
        3039,
        'Đường Công Trường Lam Sơn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cong-truong-lam-son',
        'cong truong lam son congtruonglamson'
    ),
    (
        3040,
        'Đường Công Trường Mê Linh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cong-truong-me-linh',
        'cong truong me linh congtruongmelinh'
    ),
    (
        3041,
        'Đường Công Trường Quốc Tế',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cong-truong-quoc-te',
        'cong truong quoc te congtruongquocte'
    ),
    (
        3042,
        'Đường Công Xã Paris',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cong-xa-paris',
        'cong xa paris congxaparis'
    ),
    (
        3038,
        'Đường Cống Quỳnh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'cong-quynh',
        'cong quynh congquynh'
    ),
    (
        3035,
        'Đường Chu Mạnh Trinh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'chu-manh-trinh',
        'chu manh trinh chumanhtrinh'
    ),
    (
        3055,
        'Đường Hai Bà Trưng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'hai-ba-trung',
        'hai ba trung haibatrung'
    ),
    (
        3057,
        'Đường Hàm Nghi',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ham-nghi',
        'ham nghi hamnghi'
    ),
    (
        3058,
        'Đường Hàn Thuyên',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'han-thuyen',
        'han thuyen hanthuyen'
    ),
    (
        3062,
        'Đường Hòa Hưng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'hoa-hung',
        'hoa hung hoahung'
    ),
    (
        3063,
        'Đường Hòa Mỹ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'hoa-my',
        'hoa my hoamy'
    ),
    (
        3056,
        'Đường Hải Triều',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'hai-trieu',
        'hai trieu haitrieu'
    ),
    (
        3059,
        'Đường Hồ Hảo Hớn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ho-hao-hon',
        'ho hao hon hohaohon'
    ),
    (
        3060,
        'Đường Hồ Huấn Nghiệp',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ho-huan-nghiep',
        'ho huan nghiep hohuannghiep'
    ),
    (
        3061,
        'Đường Hồ Tùng Mậu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ho-tung-mau',
        'ho tung mau hotungmau'
    ),
    (
        3064,
        'Đường Hoàng Diệu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'hoang-dieu',
        'hoang dieu hoangdieu'
    ),
    (
        3065,
        'Đường Hoàng Hoa Thám',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'hoang-hoa-tham',
        'hoang hoa tham hoanghoatham'
    ),
    (
        3066,
        'Đường Hoàng Sa',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'hoang-sa',
        'hoang sa hoangsa'
    ),
    (
        3069,
        'Đường Huỳnh Khương An',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'huynh-khuong-an',
        'huynh khuong an huynhkhuongan'
    ),
    (
        3070,
        'Đường Huỳnh Khương Ninh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'huynh-khuong-ninh',
        'huynh khuong ninh huynhkhuongninh'
    ),
    (
        3071,
        'Đường Huỳnh Thúc Kháng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'huynh-thuc-khang',
        'huynh thuc khang huynhthuckhang'
    ),
    (
        3067,
        'Đường Huyền Quang',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'huyen-quang',
        'huyen quang huyenquang'
    ),
    (
        3068,
        'Đường Huyền Trân Công Chúa',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'huyen-tran-cong-chua',
        'huyen tran cong chua huyentrancongchua'
    ),
    (
        3072,
        'Đường Ký Con',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ky-con',
        'ky con kycon'
    ),
    (
        3073,
        'Đường Lãnh Binh Thăng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'lanh-binh-thang',
        'lanh binh thang lanhbinhthang'
    ),
    (
        3074,
        'Đường Lê Anh Xuân',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-anh-xuan',
        'le anh xuan leanhxuan'
    ),
    (
        3075,
        'Đường Lê Công Kiều',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-cong-kieu',
        'le cong kieu lecongkieu'
    ),
    (
        3076,
        'Đường Lê Duẩn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-duan',
        'le duan leduan'
    ),
    (
        3077,
        'Đường Lê Lai',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-lai',
        'le lai lelai'
    ),
    (
        3078,
        'Đường Lê Lợi',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-loi',
        'le loi leloi'
    ),
    (
        3079,
        'Đường Lê Quý Đôn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-quy-don',
        'le quy don lequydon'
    ),
    (
        3080,
        'Đường Lê Thánh Tôn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-thanh-ton',
        'le thanh ton lethanhton'
    ),
    (
        3081,
        'Đường Lê Thị Hồng Gấm',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-thi-hong-gam',
        'le thi hong gam lethihonggam'
    ),
    (
        3082,
        'Đường Lê Thị Riêng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-thi-rieng',
        'le thi rieng lethirieng'
    ),
    (
        3083,
        'Đường Lê Văn Hưu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'le-van-huu',
        'le van huu levanhuu'
    ),
    (
        3086,
        'Đường Lý Chính Thắng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ly-chinh-thang',
        'ly chinh thang lychinhthang'
    ),
    (
        3087,
        'Đường Lý Tự Trọng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ly-tu-trong',
        'ly tu trong lytutrong'
    ),
    (
        3088,
        'Đường Lý Văn Phức',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ly-van-phuc',
        'ly van phuc lyvanphuc'
    ),
    (
        3085,
        'Đường Lưu Văn Lang',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'luu-van-lang',
        'luu van lang luuvanlang'
    ),
    (
        3084,
        'Đường Lương Hữu Khánh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'luong-huu-khanh',
        'luong huu khanh luonghuukhanh'
    ),
    (
        3092,
        'Đường Mai Thị Lựu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'mai-thi-luu',
        'mai thi luu maithiluu'
    ),
    (
        3089,
        'Đường Mã Lộ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ma-lo',
        'ma lo malo'
    ),
    (
        3091,
        'Đường Mạc Thị Bưởi',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'mac-thi-buoi',
        'mac thi buoi macthibuoi'
    ),
    (
        3090,
        'Đường Mạc Đĩnh Chi',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'mac-dinh-chi',
        'mac dinh chi macdinhchi'
    ),
    (
        3093,
        'Đường Nam Kỳ Khởi Nghĩa',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nam-ky-khoi-nghia',
        'nam ky khoi nghia namkykhoinghia'
    ),
    (
        3094,
        'Đường Nam Quốc Cang',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nam-quoc-cang',
        'nam quoc cang namquoccang'
    ),
    (
        3096,
        'Đường Ngô Văn Năm',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ngo-van-nam',
        'ngo van nam ngovannam'
    ),
    (
        3095,
        'Đường Ngô Đức Kế',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ngo-duc-ke',
        'ngo duc ke ngoducke'
    ),
    (
        3097,
        'Đường Nguyễn An Ninh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-an-ninh',
        'nguyen an ninh nguyenanninh'
    ),
    (
        3098,
        'Đường Nguyễn Bỉnh Khiêm',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-binh-khiem',
        'nguyen binh khiem nguyenbinhkhiem'
    ),
    (
        3100,
        'Đường Nguyễn Công Trứ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-cong-tru',
        'nguyen cong tru nguyencongtru'
    ),
    (
        3099,
        'Đường Nguyễn Cảnh Chân',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-canh-chan',
        'nguyen canh chan nguyencanhchan'
    ),
    (
        3101,
        'Đường Nguyễn Cư Trinh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-cu-trinh',
        'nguyen cu trinh nguyencutrinh'
    ),
    (
        3103,
        'Đường Nguyễn Doãn Khanh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-doan-khanh',
        'nguyen doan khanh nguyendoankhanh'
    ),
    (
        3104,
        'Đường Nguyễn Du',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-du',
        'nguyen du nguyendu'
    ),
    (
        3106,
        'Đường Nguyễn Hữu Cảnh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-huu-canh',
        'nguyen huu canh nguyenhuucanh'
    ),
    (
        3107,
        'Đường Nguyễn Hữu Cầu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-huu-cau',
        'nguyen huu cau nguyenhuucau'
    ),
    (
        3108,
        'Đường Nguyễn Hữu Nghĩa',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-huu-nghia',
        'nguyen huu nghia nguyenhuunghia'
    ),
    (
        3105,
        'Đường Nguyễn Huệ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-hue',
        'nguyen hue nguyenhue'
    ),
    (
        3109,
        'Đường Nguyễn Huy Tự',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-huy-tu',
        'nguyen huy tu nguyenhuytu'
    ),
    (
        3110,
        'Đường Nguyễn Khắc Nhu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-khac-nhu',
        'nguyen khac nhu nguyenkhacnhu'
    ),
    (
        3111,
        'Đường Nguyễn Phi Khanh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-phi-khanh',
        'nguyen phi khanh nguyenphikhanh'
    ),
    (
        3112,
        'Đường Nguyễn Siêu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-sieu',
        'nguyen sieu nguyensieu'
    ),
    (
        3115,
        'Đường Nguyễn Thành Ý',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thanh-y',
        'nguyen thanh y nguyenthanhy'
    ),
    (
        3113,
        'Đường Nguyễn Thái Bình',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thai-binh',
        'nguyen thai binh nguyenthaibinh'
    ),
    (
        3114,
        'Đường Nguyễn Thái Học',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thai-hoc',
        'nguyen thai hoc nguyenthaihoc'
    ),
    (
        3116,
        'Đường Nguyễn Thị Diệu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thi-dieu',
        'nguyen thi dieu nguyenthidieu'
    ),
    (
        3117,
        'Đường Nguyễn Thị Lắng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thi-lang',
        'nguyen thi lang nguyenthilang'
    ),
    (
        3118,
        'Đường Nguyễn Thị Minh Khai',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thi-minh-khai',
        'nguyen thi minh khai nguyenthiminhkhai'
    ),
    (
        3119,
        'Đường Nguyễn Thị Nghĩa',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thi-nghia',
        'nguyen thi nghia nguyenthinghia'
    ),
    (
        3120,
        'Đường Nguyễn Thiệp',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-thiep',
        'nguyen thiep nguyenthiep'
    ),
    (
        3121,
        'Đường Nguyễn Trãi',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-trai',
        'nguyen trai nguyentrai'
    ),
    (
        3122,
        'Đường Nguyễn Trung Ngạn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-trung-ngan',
        'nguyen trung ngan nguyentrungngan'
    ),
    (
        3123,
        'Đường Nguyễn Trung Trực',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-trung-truc',
        'nguyen trung truc nguyentrungtruc'
    ),
    (
        3124,
        'Đường Nguyễn Văn Bình',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-binh',
        'nguyen van binh nguyenvanbinh'
    ),
    (
        3126,
        'Đường Nguyễn Văn Côn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-con',
        'nguyen van con nguyenvancon'
    ),
    (
        3127,
        'Đường Nguyễn Văn Cừ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-cu',
        'nguyen van cu nguyenvancu'
    ),
    (
        3125,
        'Đường Nguyễn Văn Chiêm',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-chiem',
        'nguyen van chiem nguyenvanchiem'
    ),
    (
        3129,
        'Đường Nguyễn Văn Giai',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-giai',
        'nguyen van giai nguyenvangiai'
    ),
    (
        3130,
        'Đường Nguyễn Văn Linh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-linh',
        'nguyen van linh nguyenvanlinh'
    ),
    (
        3131,
        'Đường Nguyễn Văn Mai',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-mai',
        'nguyen van mai nguyenvanmai'
    ),
    (
        3132,
        'Đường Nguyễn Văn Nguyễn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-nguyen',
        'nguyen van nguyen nguyenvannguyen'
    ),
    (
        3133,
        'Đường Nguyễn Văn Thủ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-thu',
        'nguyen van thu nguyenvanthu'
    ),
    (
        3134,
        'Đường Nguyễn Văn Tráng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-trang',
        'nguyen van trang nguyenvantrang'
    ),
    (
        3135,
        'Đường Nguyễn Văn Trỗi',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-troi',
        'nguyen van troi nguyenvantroi'
    ),
    (
        3136,
        'Đường Nguyễn Văn Trường',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-truong',
        'nguyen van truong nguyenvantruong'
    ),
    (
        3128,
        'Đường Nguyễn Văn Đại',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-van-dai',
        'nguyen van dai nguyenvandai'
    ),
    (
        3102,
        'Đường Nguyễn Đình Chiểu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'nguyen-dinh-chieu',
        'nguyen dinh chieu nguyendinhchieu'
    ),
    (
        3137,
        'Đường Pasteur',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'pasteur',
        'pasteur pasteur'
    ),
    (
        3142,
        'Đường Phan Bội Châu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-boi-chau',
        'phan boi chau phanboichau'
    ),
    (
        3143,
        'Đường Phan Chu Trinh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-chu-trinh',
        'phan chu trinh phanchutrinh'
    ),
    (
        3144,
        'Đường Phan Kế Bính',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-ke-binh',
        'phan ke binh phankebinh'
    ),
    (
        3145,
        'Đường Phan Liêm',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-liem',
        'phan liem phanliem'
    ),
    (
        3146,
        'Đường Phan Ngữ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-ngu',
        'phan ngu phanngu'
    ),
    (
        3147,
        'Đường Phan Tôn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-ton',
        'phan ton phanton'
    ),
    (
        3149,
        'Đường Phan Văn Trường',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-van-truong',
        'phan van truong phanvantruong'
    ),
    (
        3148,
        'Đường Phan Văn Đạt',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phan-van-dat',
        'phan van dat phanvandat'
    ),
    (
        3150,
        'Đường Phó Đức Chính',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'pho-duc-chinh',
        'pho duc chinh phoducchinh'
    ),
    (
        3151,
        'Đường Phùng Khắc Khoan',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'phung-khac-khoan',
        'phung khac khoan phungkhackhoan'
    ),
    (
        3138,
        'Đường Phạm Hồng Thái',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'pham-hong-thai',
        'pham hong thai phamhongthai'
    ),
    (
        3139,
        'Đường Phạm Ngọc Thạch',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'pham-ngoc-thach',
        'pham ngoc thach phamngocthach'
    ),
    (
        3140,
        'Đường Phạm Ngũ Lão',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'pham-ngu-lao',
        'pham ngu lao phamngulao'
    ),
    (
        3141,
        'Đường Phạm Viết Chánh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'pham-viet-chanh',
        'pham viet chanh phamvietchanh'
    ),
    (
        3152,
        'Đường Quang Trung',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'quang-trung',
        'quang trung quangtrung'
    ),
    (
        3153,
        'Đường Sương Nguyệt Ánh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'suong-nguyet-anh',
        'suong nguyet anh suongnguyetanh'
    ),
    (
        3162,
        'Đường Tôn Thất Tùng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ton-that-tung',
        'ton that tung tonthattung'
    ),
    (
        3161,
        'Đường Tôn Thất Thiệp',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ton-that-thiep',
        'ton that thiep tonthatthiep'
    ),
    (
        3160,
        'Đường Tôn Thất Đạm',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ton-that-dam',
        'ton that dam tonthatdam'
    ),
    (
        3159,
        'Đường Tôn Đức Thắng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'ton-duc-thang',
        'ton duc thang tonducthang'
    ),
    (
        3180,
        'Đường Tú Xương',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tu-xuong',
        'tu xuong tuxuong'
    ),
    (
        3155,
        'Đường Thái Bình',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'thai-binh',
        'thai binh thaibinh'
    ),
    (
        3156,
        'Đường Thái Văn Lung',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'thai-van-lung',
        'thai van lung thaivanlung'
    ),
    (
        3154,
        'Đường Thạch Thị Thanh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'thach-thi-thanh',
        'thach thi thanh thachthithanh'
    ),
    (
        3158,
        'Đường Thủ Khoa Huân',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'thu-khoa-huan',
        'thu khoa huan thukhoahuan'
    ),
    (
        3157,
        'Đường Thi Sách',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'thi-sach',
        'thi sach thisach'
    ),
    (
        3163,
        'Đường Trần Bình Trọng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-binh-trong',
        'tran binh trong tranbinhtrong'
    ),
    (
        3164,
        'Đường Trần Cao Vân',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-cao-van',
        'tran cao van trancaovan'
    ),
    (
        3166,
        'Đường Trần Doãn Khanh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-doan-khanh',
        'tran doan khanh trandoankhanh'
    ),
    (
        3167,
        'Đường Trần Hưng Đạo',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-hung-dao',
        'tran hung dao tranhungdao'
    ),
    (
        3169,
        'Đường Trần Khánh Dư',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-khanh-du',
        'tran khanh du trankhanhdu'
    ),
    (
        3168,
        'Đường Trần Khắc Chân',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-khac-chan',
        'tran khac chan trankhacchan'
    ),
    (
        31159,
        'đường Trần Nguyên Đán',
        NULL,
        NULL,
        '50',
        '550',
        'đường',
        'tran-nguyen-dan',
        'tran nguyen dan trannguyendan'
    ),
    (
        3170,
        'Đường Trần Nhật Duật',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-nhat-duat',
        'tran nhat duat trannhatduat'
    ),
    (
        3171,
        'Đường Trần Quang Khải',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-quang-khai',
        'tran quang khai tranquangkhai'
    ),
    (
        3172,
        'Đường Trần Quốc Thảo',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-quoc-thao',
        'tran quoc thao tranquocthao'
    ),
    (
        3173,
        'Đường Trần Quý Khoách',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-quy-khoach',
        'tran quy khoach tranquykhoach'
    ),
    (
        3174,
        'Đường Trần Tuấn Khải',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-tuan-khai',
        'tran tuan khai trantuankhai'
    ),
    (
        3175,
        'Đường Trần Văn Kỷ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-van-ky',
        'tran van ky tranvanky'
    ),
    (
        3165,
        'Đường Trần Đình Xu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'tran-dinh-xu',
        'tran dinh xu trandinhxu'
    ),
    (
        3176,
        'Đường Trịnh Văn Cấn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'trinh-van-can',
        'trinh van can trinhvancan'
    ),
    (
        3179,
        'Đường Trường Sa',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'truong-sa',
        'truong sa truongsa'
    ),
    (
        3178,
        'Đường Trương Hán Siêu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'truong-han-sieu',
        'truong han sieu truonghansieu'
    ),
    (
        3177,
        'Đường Trương Định',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'truong-dinh',
        'truong dinh truongdinh'
    ),
    (
        3182,
        'Đường Võ Thị Sáu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'vo-thi-sau',
        'vo thi sau vothisau'
    ),
    (
        3183,
        'Đường Võ Văn Kiệt',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'vo-van-kiet',
        'vo van kiet vovankiet'
    ),
    (
        3181,
        'Đường Vạn Kiếp',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'van-kiep',
        'van kiep vankiep'
    ),
    (
        3184,
        'Đường Xô Viết Nghệ Tĩnh',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'xo-viet-nghe-tinh',
        'xo viet nghe tinh xovietnghetinh'
    ),
    (
        3185,
        'Đường Yersin',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'yersin',
        'yersin yersin'
    ),
    (
        3053,
        'Đường Đông Du',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dong-du',
        'dong du dongdu'
    ),
    (
        3043,
        'Đường Đại Lộ Đông Tây',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dai-lo-dong-tay',
        'dai lo dong tay dailodongtay'
    ),
    (
        3044,
        'Đường Đặng Dung',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dang-dung',
        'dang dung dangdung'
    ),
    (
        3045,
        'Đường Đặng Tất',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dang-tat',
        'dang tat dangtat'
    ),
    (
        3046,
        'Đường Đặng Thị Nhu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dang-thi-nhu',
        'dang thi nhu dangthinhu'
    ),
    (
        3047,
        'Đường Đặng Trần Côn',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dang-tran-con',
        'dang tran con dangtrancon'
    ),
    (
        3048,
        'Đường Đề Thám',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'de-tham',
        'de tham detham'
    ),
    (
        3054,
        'Đường Đồng Khởi',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dong-khoi',
        'dong khoi dongkhoi'
    ),
    (
        3052,
        'Đường Đỗ Quang Đẩu',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'do-quang-dau',
        'do quang dau doquangdau'
    ),
    (
        3049,
        'Đường Điện Biên Phủ',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dien-bien-phu',
        'dien bien phu dienbienphu'
    ),
    (
        3050,
        'Đường Đinh Công Tráng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dinh-cong-trang',
        'dinh cong trang dinhcongtrang'
    ),
    (
        3051,
        'Đường Đinh Tiên Hoàng',
        NULL,
        NULL,
        '50',
        '550',
        'Đường',
        'dinh-tien-hoang',
        'dinh tien hoang dinhtienhoang'
    );

-- Inserting data into Districts table
INSERT INTO
    Districts (
        id,
        TCTKid,
        Name,
        ProvinceId,
        Prefix,
        Keyword,
        latlng,
        Lookup
    )
VALUES (
        0,
        NULL,
        'Chọn Quận/Huyện',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL
    ),
    (
        29,
        '281',
        'Huyện Ứng Hòa',
        '1',
        'Huyện',
        'ung-hoa',
        '20.7110772,105.8143304',
        'ung hoa unghoa'
    ),
    (
        19,
        '271',
        'Huyện Ba Vì',
        '1',
        'Huyện',
        'ba-vi',
        '21.1559766,105.3749427',
        'ba vi bavi'
    ),
    (
        1,
        '001',
        'Quận Ba Đình',
        '1',
        'Quận',
        'ba-dinh',
        '21.0365377,105.8285908',
        'ba dinh badinh'
    ),
    (
        15,
        '021',
        'Quận Bắc Từ Liêm',
        '1',
        'Quận',
        'bac-tu-liem',
        '21.0712548,105.7644855',
        'bac tu liem bactuliem'
    ),
    (
        5,
        '005',
        'Quận Cầu Giấy',
        '1',
        'Quận',
        'cau-giay',
        '21.0295015,105.7914212',
        'cau giay caugiay'
    ),
    (
        25,
        '277',
        'Huyện Chương Mỹ',
        '1',
        'Huyện',
        'chuong-my',
        '20.8785159,105.6492335',
        'chuong my chuongmy'
    ),
    (
        12,
        '018',
        'Huyện Gia Lâm',
        '1',
        'Huyện',
        'gia-lam',
        '21.0238721,105.9705013',
        'gia lam gialam'
    ),
    (
        7,
        '007',
        'Quận Hai Bà Trưng',
        '1',
        'Quận',
        'hai-ba-trung',
        '21.0064704,105.8578519',
        'hai ba trung haibatrung'
    ),
    (
        17,
        '268',
        'Quận Hà Đông',
        '1',
        'Quận',
        'ha-dong',
        '20.9551855,105.7580110',
        'ha dong hadong'
    ),
    (
        22,
        '274',
        'Huyện Hoài Đức',
        '1',
        'Huyện',
        'hoai-duc',
        '21.0229256,105.7034794',
        'hoai duc hoaiduc'
    ),
    (
        2,
        '002',
        'Quận Hoàn Kiếm',
        '1',
        'Quận',
        'hoan-kiem',
        '21.0302237,105.8523115',
        'hoan kiem hoankiem'
    ),
    (
        8,
        '008',
        'Quận Hoàng Mai',
        '1',
        'Quận',
        'hoang-mai',
        '20.9757581,105.8626556',
        'hoang mai hoangmai'
    ),
    (
        4,
        '004',
        'Quận Long Biên',
        '1',
        'Quận',
        'long-bien',
        '21.0359662,105.9021921',
        'long bien longbien'
    ),
    (
        16,
        '250',
        'Huyện Mê Linh',
        '1',
        'Huyện',
        'me-linh',
        '21.1807885,105.7072570',
        'me linh melinh'
    ),
    (
        30,
        '282',
        'Huyện Mỹ Đức',
        '1',
        'Huyện',
        'my-duc',
        '20.6973826,105.7157754',
        'my duc myduc'
    ),
    (
        13,
        '019',
        'Quận Nam Từ Liêm',
        '1',
        'Quận',
        'nam-tu-liem',
        '21.0173512,105.7613329',
        'nam tu liem namtuliem'
    ),
    (
        28,
        '280',
        'Huyện Phú Xuyên',
        '1',
        'Huyện',
        'phu-xuyen',
        '20.7290459,105.9102398',
        'phu xuyen phuxuyen'
    ),
    (
        20,
        '272',
        'Huyện Phúc Thọ',
        '1',
        'Huyện',
        'phuc-tho',
        '21.1096428,105.5709447',
        'phuc tho phuctho'
    ),
    (
        23,
        '275',
        'Huyện Quốc Oai',
        '1',
        'Huyện',
        'quoc-oai',
        '20.9779128,105.6295922',
        'quoc oai quocoai'
    ),
    (
        10,
        '016',
        'Huyện Sóc Sơn',
        '1',
        'Huyện',
        'soc-son',
        '21.2808747,105.8292403',
        'soc son socson'
    ),
    (
        18,
        '269',
        'Thị xã Sơn Tây',
        '1',
        'Thị xã',
        'son-tay',
        '21.1386671,105.5056335',
        'son tay sontay'
    ),
    (
        3,
        '003',
        'Quận Tây Hồ',
        '1',
        'Quận',
        'tay-ho',
        '21.0683576,105.8240984',
        'tay ho tayho'
    ),
    (
        26,
        '278',
        'Huyện Thanh Oai',
        '1',
        'Huyện',
        'thanh-oai',
        '20.8602693,105.7801644',
        'thanh oai thanhoai'
    ),
    (
        14,
        '020',
        'Huyện Thanh Trì',
        '1',
        'Huyện',
        'thanh-tri',
        '20.9408967,105.8365081',
        'thanh tri thanhtri'
    ),
    (
        9,
        '009',
        'Quận Thanh Xuân',
        '1',
        'Quận',
        'thanh-xuan',
        '20.9944171,105.8171316',
        'thanh xuan thanhxuan'
    ),
    (
        24,
        '276',
        'Huyện Thạch Thất',
        '1',
        'Huyện',
        'thach-that',
        '21.0235566,105.5537358',
        'thach that thachthat'
    ),
    (
        27,
        '279',
        'Huyện Thường Tín',
        '1',
        'Huyện',
        'thuong-tin',
        '20.8319978,105.8700643',
        'thuong tin thuongtin'
    ),
    (
        21,
        '273',
        'Huyện Đan Phượng',
        '1',
        'Huyện',
        'dan-phuong',
        '21.1196271,105.6784682',
        'dan phuong danphuong'
    ),
    (
        11,
        '017',
        'Huyện Đông Anh',
        '1',
        'Huyện',
        'dong-anh',
        '21.1367358,105.8460325',
        'dong anh donganh'
    ),
    (
        6,
        '006',
        'Quận Đống Đa',
        '1',
        'Quận',
        'dong-da',
        '21.0146852,105.8235426',
        'dong da dongda'
    );