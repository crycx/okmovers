<?php

add_action('after_setup_theme', 'okmovers_theme_setup');
function okmovers_theme_setup(): void
{
    load_theme_textdomain('okmovers', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('editor-styles');
    add_editor_style('assets/css/main.css');

    register_nav_menus([
        'primary' => __('Primary Menu', 'okmovers'),
        'footer'  => __('Footer Menu', 'okmovers'),
        'legal'   => __('Legal Menu', 'okmovers'),
    ]);

    add_image_size('okmovers-hero', 1600, 900, true);
    add_image_size('okmovers-card', 720, 540, true);
}

add_action('wp_enqueue_scripts', 'okmovers_enqueue_assets');
function okmovers_enqueue_assets(): void
{
    $theme_uri = get_template_directory_uri();

    wp_enqueue_style(
        'okmovers-main',
        $theme_uri . '/assets/css/main.css',
        [],
        OKMOVERS_THEME_VERSION
    );

    wp_enqueue_script(
        'okmovers-main',
        $theme_uri . '/assets/js/main.js',
        [],
        OKMOVERS_THEME_VERSION,
        true
    );

    wp_localize_script('okmovers-main', 'okmoversTheme', [
        'menuLabelOpen'   => __('Open menu', 'okmovers'),
        'menuLabelClose'  => __('Close menu', 'okmovers'),
        'formStatus'      => sanitize_key((string) wp_unslash($_GET['form-status'] ?? '')),
        'formMessageId'   => sanitize_key((string) wp_unslash($_GET['form-message'] ?? '')),
        'ajaxUrl'         => admin_url('admin-ajax.php'),
    ]);
}

add_filter('body_class', 'okmovers_body_classes');
function okmovers_body_classes(array $classes): array
{
    if (is_front_page()) {
        $classes[] = 'is-front-page';
    }

    if (is_page()) {
        $classes[] = 'is-standard-page';
    }

    return $classes;
}

add_filter('excerpt_length', static function (): int {
    return 24;
});

add_filter('excerpt_more', static function (): string {
    return '...';
});
