ALTER TABLE students CHANGE father_pic father_pic VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE mother_pic mother_pic VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE guardian_pic guardian_pic VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE height height VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE weight weight VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE measurement_date measurement_date VARCHAR(200) NULL DEFAULT NULL, CHANGE dis_reason dis_reason VARCHAR(200) NULL DEFAULT NULL, CHANGE dis_note dis_note VARCHAR(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;


ALTER TABLE students CHANGE parent_id parent_id VARCHAR(225) NULL DEFAULT NULL;


ALTER TABLE students CHANGE route_id route_id VARCHAR(225) NULL DEFAULT NULL, CHANGE school_house_id school_house_id VARCHAR(225) NULL DEFAULT NULL, CHANGE blood_group blood_group VARCHAR(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE vehroute_id vehroute_id VARCHAR(225) NULL DEFAULT NULL, CHANGE hostel_room_id hostel_room_id VARCHAR(225) NULL DEFAULT NULL, CHANGE guardian_is guardian_is VARCHAR(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE guardian_occupation guardian_occupation VARCHAR(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE disable_at disable_at VARCHAR(225) NULL DEFAULT NULL;



ALTER TABLE sch_settings CHANGE languages languages VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE date_format date_format VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE time_format time_format VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE currency currency VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE currency_symbol currency_symbol VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE cron_secret_key cron_secret_key VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE class_teacher class_teacher VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE start_month start_month VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE admin_logo admin_logo VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE admin_small_logo admin_small_logo VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE adm_start_from adm_start_from VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE staffid_start_from staffid_start_from VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE online_admission_payment online_admission_payment VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE online_admission_amount online_admission_amount VARCHAR(255) NULL DEFAULT NULL, CHANGE online_admission_instruction online_admission_instruction TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE online_admission_conditions online_admission_conditions TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE category category VARCHAR(255) NULL DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) NULL DEFAULT NULL, CHANGE guardian_name guardian_name VARCHAR(255) NULL DEFAULT NULL, CHANGE guardian_phone guardian_phone VARCHAR(255) NULL DEFAULT NULL, CHANGE guardian_occupation guardian_occupation VARCHAR(255) NULL DEFAULT NULL, CHANGE ifsc_code ifsc_code VARCHAR(255) NULL DEFAULT NULL, CHANGE bank_name bank_name VARCHAR(255) NULL DEFAULT NULL, CHANGE mobile_api_url mobile_api_url VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE start_week start_week VARCHAR(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE my_question my_question VARCHAR(255) NULL DEFAULT NULL;


ALTER TABLE students CHANGE image image TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;


ALTER TABLE item CHANGE description description TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;


ALTER TABLE certificates CHANGE certificate_text certificate_text TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE left_header left_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE center_header center_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE right_header right_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE left_footer left_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE right_footer right_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE center_footer center_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE background_image background_image VARCHAR(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL, CHANGE status status TINYINT(1) NULL DEFAULT NULL, CHANGE header_height header_height INT NULL DEFAULT NULL, CHANGE content_height content_height INT NULL DEFAULT NULL, CHANGE footer_height footer_height INT NULL DEFAULT NULL, CHANGE content_width content_width INT NULL DEFAULT NULL, CHANGE enable_student_image enable_student_image TINYINT(1) NULL DEFAULT NULL COMMENT '0=no,1=yes', CHANGE enable_image_height enable_image_height INT NULL DEFAULT NULL;



ALTER TABLE certificates CHANGE left_header left_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL, CHANGE center_header center_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL, CHANGE right_header right_header TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL, CHANGE left_footer left_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL, CHANGE right_footer right_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL, CHANGE center_footer center_footer TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL;


//
ALTER TABLE `homework` CHANGE `document` `document` VARCHAR(256) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL;


ALTER TABLE `users` CHANGE `verification_code` `verification_code` TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL;


ALTER TABLE `staff` CHANGE `date_of_leaving` `date_of_leaving` DATE NULL DEFAULT NULL;
