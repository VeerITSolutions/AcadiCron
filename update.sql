-- Alter students table
ALTER TABLE students
  CHANGE father_pic father_pic VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE mother_pic mother_pic VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE guardian_pic guardian_pic VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE height height VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE weight weight VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE measurement_date measurement_date VARCHAR(200) NULL DEFAULT NULL,
  CHANGE dis_reason dis_reason VARCHAR(200) NULL DEFAULT NULL,
  CHANGE dis_note dis_note VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE parent_id parent_id VARCHAR(225) NULL DEFAULT NULL,
  CHANGE route_id route_id VARCHAR(225) NULL DEFAULT NULL,
  CHANGE school_house_id school_house_id VARCHAR(225) NULL DEFAULT NULL,
  CHANGE blood_group blood_group VARCHAR(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE vehroute_id vehroute_id VARCHAR(225) NULL DEFAULT NULL,
  CHANGE hostel_room_id hostel_room_id VARCHAR(225) NULL DEFAULT NULL,
  CHANGE guardian_is guardian_is VARCHAR(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE guardian_occupation guardian_occupation VARCHAR(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE disable_at disable_at VARCHAR(225) NULL DEFAULT NULL,
  CHANGE image image TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;

-- Alter sch_settings table
ALTER TABLE sch_settings
  CHANGE languages languages VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE date_format date_format VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE time_format time_format VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE currency currency VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE currency_symbol currency_symbol VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE cron_secret_key cron_secret_key VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE class_teacher class_teacher VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE start_month start_month VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE admin_logo admin_logo VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE admin_small_logo admin_small_logo VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE adm_start_from adm_start_from VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE staffid_start_from staffid_start_from VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE online_admission_payment online_admission_payment VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE online_admission_amount online_admission_amount VARCHAR(255) NULL DEFAULT NULL,
  CHANGE online_admission_instruction online_admission_instruction TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE online_admission_conditions online_admission_conditions TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE category category VARCHAR(255) NULL DEFAULT NULL,
  CHANGE lastname lastname VARCHAR(255) NULL DEFAULT NULL,
  CHANGE guardian_name guardian_name VARCHAR(255) NULL DEFAULT NULL,
  CHANGE guardian_phone guardian_phone VARCHAR(255) NULL DEFAULT NULL,
  CHANGE guardian_occupation guardian_occupation VARCHAR(255) NULL DEFAULT NULL,
  CHANGE ifsc_code ifsc_code VARCHAR(255) NULL DEFAULT NULL,
  CHANGE bank_name bank_name VARCHAR(255) NULL DEFAULT NULL,
  CHANGE mobile_api_url mobile_api_url VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE start_week start_week VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE my_question my_question VARCHAR(255) NULL DEFAULT NULL;

-- Alter item table
ALTER TABLE item
  CHANGE description description TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;

-- Alter certificates table
ALTER TABLE certificates
  CHANGE certificate_text certificate_text TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE left_header left_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  CHANGE center_header center_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  CHANGE right_header right_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  CHANGE left_footer left_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  CHANGE right_footer right_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  CHANGE center_footer center_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  CHANGE background_image background_image VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE status status TINYINT(1) NULL DEFAULT NULL,
  CHANGE header_height header_height INT NULL DEFAULT NULL,
  CHANGE content_height content_height INT NULL DEFAULT NULL,
  CHANGE footer_height footer_height INT NULL DEFAULT NULL,
  CHANGE content_width content_width INT NULL DEFAULT NULL,
  CHANGE enable_student_image enable_student_image TINYINT(1) NULL DEFAULT NULL COMMENT '0=no,1=yes',
  CHANGE enable_image_height enable_image_height INT NULL DEFAULT NULL;

-- Alter homework table
ALTER TABLE homework
  CHANGE subject_id subject_id INT NULL DEFAULT NULL,
  CHANGE document document VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;

-- Alter users table
ALTER TABLE users
  CHANGE verification_code verification_code TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL;

-- Alter staff table
ALTER TABLE staff
  CHANGE date_of_leaving date_of_leaving DATE NULL DEFAULT NULL,
  CHANGE qualification qualification VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE work_exp work_exp VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE name name VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE surname surname VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE father_name father_name VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE mother_name mother_name VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE contact_no contact_no VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE emergency_contact_no emergency_contact_no VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE email email VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE dob dob DATE NULL DEFAULT NULL,
  CHANGE marital_status marital_status VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE local_address local_address VARCHAR(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE permanent_address permanent_address VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE note note VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE image image VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE password password TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE gender gender VARCHAR(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE account_title account_title VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE bank_account_no bank_account_no VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE bank_name bank_name VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE ifsc_code ifsc_code VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE bank_branch bank_branch VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE payscale payscale VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE basic_salary basic_salary VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE epf_no epf_no VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE contract_type contract_type VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE shift shift VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE location location VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE facebook facebook VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE twitter twitter VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE linkedin linkedin VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE instagram instagram VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE resume resume VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE joining_letter joining_letter VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE resignation_letter resignation_letter VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE other_document_name other_document_name VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE other_document_file other_document_file VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE user_id user_id INT NULL DEFAULT NULL,
  CHANGE is_active is_active INT NULL DEFAULT NULL,
  CHANGE verification_code verification_code VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL,
  CHANGE lang_id lang_id INT NULL DEFAULT NULL;

-- Create new tables
DROP TABLE IF EXISTS send_ecampus_circular;
CREATE TABLE send_ecampus_circular (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(50) DEFAULT NULL,
  publish_date date DEFAULT NULL,
  date date DEFAULT NULL,
  message text,
  visible_student varchar(10) NOT NULL DEFAULT 'no',
  visible_staff varchar(10) NOT NULL DEFAULT 'no',
  visible_parent varchar(10) NOT NULL DEFAULT 'no',
  created_by varchar(60) DEFAULT NULL,
  created_id int DEFAULT NULL,
  is_active varchar(255) DEFAULT 'no',
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at date DEFAULT NULL,
  path text,
  class_id varchar(30) DEFAULT NULL,
  secid varchar(30) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS send_ecampus_message;
CREATE TABLE send_ecampus_message (
  id int NOT NULL AUTO_INCREMENT,
  title varchar(50) DEFAULT NULL,
  publish_date date DEFAULT NULL,
  date date DEFAULT NULL,
  message text,
  visible_student varchar(10) NOT NULL DEFAULT 'no',
  visible_staff varchar(10) NOT NULL DEFAULT 'no',
  visible_parent varchar(10) NOT NULL DEFAULT 'no',
  created_by varchar(60) DEFAULT NULL,
  created_id int DEFAULT NULL,
  is_active varchar(255) DEFAULT 'no',
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_at date DEFAULT NULL,
  path text,
  class_id varchar(30) DEFAULT NULL,
  secid varchar(30) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS notification_ecampus_cicular_roles;
CREATE TABLE notification_ecampus_cicular_roles (
  id int NOT NULL AUTO_INCREMENT,
  send_ecampus_cicular_id int DEFAULT NULL,
  role_id int DEFAULT NULL,
  is_active int DEFAULT '0',
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY send_ecampus_cicular_id (send_ecampus_cicular_id),
  KEY role_id (role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS notification_ecampus_message_roles;
CREATE TABLE notification_ecampus_message_roles (
  id int NOT NULL AUTO_INCREMENT,
  send_ecampus_message_id int DEFAULT NULL,
  role_id int DEFAULT NULL,
  is_active int DEFAULT '0',
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY send_ecampus_message_id (send_ecampus_message_id),
  KEY role_id (role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS classwork_evaluation;
CREATE TABLE classwork_evaluation (
  id int NOT NULL AUTO_INCREMENT,
  classwork_id int NOT NULL,
  student_id int NOT NULL,
  student_session_id int DEFAULT NULL,
  date date NOT NULL,
  status varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS classwork;
CREATE TABLE classwork (
  id int NOT NULL AUTO_INCREMENT,
  class_id int NOT NULL,
  section_id int NOT NULL,
  session_id int NOT NULL,
  classwork_date date NOT NULL,
  submit_date date NOT NULL,
  staff_id int NOT NULL,
  subject_group_subject_id int DEFAULT NULL,
  subject_id int DEFAULT NULL,
  description text,
  create_date date NOT NULL,
  evaluation_date date NOT NULL,
  document varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  created_by int NOT NULL,
  evaluated_by int NOT NULL,
  PRIMARY KEY (id),
  KEY subject_group_subject_id (subject_group_subject_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT,
  `last_used_at` TIMESTAMP NULL,
  `expires_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  INDEX `tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `front_cms_media_gallery` CHANGE `vid_url` `vid_url` TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL;
ALTER TABLE `front_cms_media_gallery` CHANGE `vid_title` `vid_title` VARCHAR(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;
