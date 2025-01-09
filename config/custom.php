<?php

/* use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider; */

return [
    'balance_group' => env('BALANCE_GROUP', 'Balance Master'),
    'balance_type' => env('BALANCE_TYPE', 'Previous Session Balance'),
    'blog_theme' => env('BLOG_THEME', 'default'),
    'front_page_url' => env('FRONT_PAGE_URL', 'page/'),
    'front_page_read_url' => env('FRONT_PAGE_READ_URL', 'read/'),
    'front_event_content' => env('FRONT_EVENT_CONTENT', 'events'),
    'front_notice_content' => env('FRONT_NOTICE_CONTENT', 'notice'),
    'front_gallery_content' => env('FRONT_GALLERY_CONTENT', 'gallery'),
    'front_banner_content' => env('FRONT_BANNER_CONTENT', 'banner'),
    'front_home_page_slug' => env('FRONT_HOME_PAGE_SLUG', 'home'),
    'front_themes' => [
        'default' => env('FRONT_THEMES_DEFAULT', 'theme_default.jpg'),
        'yellow' => env('FRONT_THEMES_YELLOW', 'theme_yellow.jpg'),
        'darkgray' => env('FRONT_THEMES_DARKGRAY', 'theme_darkgray.jpg'),
        'bold_blue' => env('FRONT_THEMES_BOLD_BLUE', 'theme_bold_blue.jpg'),
        'shadow_white' => env('FRONT_THEMES_SHADOW_WHITE', 'theme_shadow_white.jpg'),
        'material_pink' => env('FRONT_THEMES_MATERIAL_PINK', 'theme_material_pink.jpg'),
    ],


    'adm_digit_length' => 6,

    'exam_type' => [
        'basic_system' => "Basic system",
        'school_grade_system' => "School grade system",
        'coll_grade_system' => "Coll grade system",
        'gpa' =>"Gpa",
    ],

    'image_validate' => [
        'allowed_mime_type' => ['image/jpeg', 'image/jpg', 'image/png'],
        'allowed_extension' => [
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 
            'JPG', 'JPEG', 'PNG', 'GIF', 'BMP', 'SVG', 
            'Jpg', 'Jpeg', 'Png', 'Gif', 'Bmp', 'Svg'
        ],
        'upload_size' => 10048576, // bytes
    ],

    'csv_validate' => [
        'allowed_mime_type' => [
            'application/vnd.ms-excel', 
            'text/plain', 
            'text/csv', 
            'text/tsv'
        ],
        'allowed_extension' => ['csv'],
        'upload_size' => 100048576, // bytes
    ],

    'file_validate' => [
        'allowed_mime_type' => [
            'application/pdf',
            'application/msword',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'image/jpeg',
            'image/jpg',
            'image/png',
            'audio/mpeg',
            'audio/mpg',
            'audio/mpeg3',
            'audio/mp3',
            'audio/aac',
            'audio/midi',
            'audio/x-midi',
            'audio/ogg',
            'audio/opus',
            'audio/wav',
            'audio/webm',
            'audio/3gpp',
            'audio/3gpp2',
            'video/mp4',
            'video/mpeg',
            'video/3gpp',
            'video/webm',
            'video/x-msvideo',
            'video/msvideo',
            'video/avi',
            'application/x-troff-msvideo',
            'application/xls',
            'video/x-ms-wmv',
            'video/x-ms-asf',
            'application/octet-stream',
            'video/quicktime',
            'video/x-matroska',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ],
        'allowed_extension' => [
            'pptx', 'ppt', 'pdf', 'doc', 'xls', 'ppt', 'docx', 'xlsx', 
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'mp3', 'aac', 
            'mp4', 'mpg', '3gp', 'webm', 'mpeg', 'avi', 'wmv', 'mov', 
            'mid', 'midi', 'oga', 'opus', 'wav', 'weba', '3g2', 'PPTX', 
            'PPT', 'WEBA', 'MPEG', 'WAV', 'OPUS', 'MIDI', 'OGA', 'MID', 
            'PDF', 'DOC', 'XLS', 'DOCX', 'XLSX', 'JPG', 'JPEG', 'PNG', 
            'GIF', 'BMP', 'SVG', 'MP3', 'AAC', 'MP4', 'MPG', '3GP', 
            'WEBM', 'AVI', 'WMV', 'MOV', 'Pptx', 'Ppt', 'Pdf', 'Doc', 
            'Xls', 'Docx', 'Xlsx', 'Jpg', 'Jpeg', 'Png', 'Gif', 'Bmp', 
            'Svg', 'Mp3', 'Aac', 'Mp4', 'Mpg', '3Gp', 'Webm', 'Avi', 
            'Wmv', 'Mov', 'mkv', 'dta'
        ],
        'upload_size' => 100048576, // bytes
    ],

    
];
