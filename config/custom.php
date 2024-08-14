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
];
