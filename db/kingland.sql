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