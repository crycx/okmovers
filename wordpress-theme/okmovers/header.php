<?php
$phone = okmovers_get_option_field('company_phone', '+372 504 7187');
$email = okmovers_get_option_field('company_email', 'info@okmovers.ee');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site-shell">
    <header class="site-header">
        <div class="site-header__inner container">
            <div class="site-branding">
              <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
                <?php else : ?>
                        <a class="site-branding__link" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <span class="site-branding__title"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation">
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
                <span class="menu-toggle__line"></span>
                <span class="screen-reader-text"><?php esc_html_e('Open menu', 'okmovers'); ?></span>
            </button>

            <nav class="site-navigation" id="site-navigation" aria-label="<?php esc_attr_e('Primary menu', 'okmovers'); ?>">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'site-navigation__menu',
                    'fallback_cb'    => 'okmovers_primary_menu_fallback',
                ]);
                ?>
            </nav>

            <div class="site-header__contact">
                <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', (string) $phone)); ?>"><?php echo esc_html($phone); ?></a>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </div>
        </div>
    </header>
    <main class="site-main">
