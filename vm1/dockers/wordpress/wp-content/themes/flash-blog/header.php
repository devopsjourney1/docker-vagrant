<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package flash_blog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site <?php if (flash_blog_get_option('enable_featured_page_section') == 1) {
    echo "content-block";
} ?>">
<?php if (has_header_image()) {
    $flash_blog_header_img_cl = "header-image";
} else {
    $flash_blog_header_img_cl = "header-image-null";
}
$flash_blog_header_color = "";
$flash_blog_header_color = flash_blog_get_option('header_bg_scheme');
if ($flash_blog_header_color == 'dark-scheme') {
    $flash_blog_header_colors = "dark-scheme";
} else {
    $flash_blog_header_colors = "light-scheme";
}
$flash_blog_header_img = get_header_image(); ?>
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'flash-blog'); ?></a>
    <header id="masthead" class="site-header <?php echo esc_attr($flash_blog_header_img_cl); ?> <?php echo esc_attr($flash_blog_header_colors); ?>" data-background="<?php echo esc_url($flash_blog_header_img); ?>">
        <!-- header -->
        <div class="wrapper">
            <div class="row">
                <div class="col col-full">
                    <div class="site-branding">
                        <div class="logo">
                            <?php
                            the_custom_logo();
                            if (is_front_page() && is_home()) : ?>
                                <h1 class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </h1>
                            <?php else : ?>
                                <p class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </p>
                            <?php
                            endif;

                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) : ?>
                                <p class="site-description">
                                    <?php echo esc_html($description); ?>
                                </p>
                            <?php
                            endif; ?>
                        </div>
                    </div>
                    <div class="united-navigation">
                        <nav id="site-navigation" class="main-navigation">
                            <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                                <span class="screen-reader-text"><?php esc_html_e('Primary Menu', 'flash-blog'); ?></span>
                                <i class="toogle-icon"></i>
                            </span>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'mainnav',
                                'menu_id' => 'primary-menu',
                                'container' => 'div',
                                'container_class' => 'menu'
                            ));
                            ?>
                            <span class="icon-search">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                                    <g>
                                        <path d="M51.6,96.7c11,0,21-3.9,28.8-10.5l35,35c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2c1.6-1.6,1.6-4.2,0-5.8l-35-35   c6.5-7.8,10.5-17.9,10.5-28.8c0-24.9-20.2-45.1-45.1-45.1C26.8,6.5,6.5,26.8,6.5,51.6C6.5,76.5,26.8,96.7,51.6,96.7z M51.6,14.7   c20.4,0,36.9,16.6,36.9,36.9C88.5,72,72,88.5,51.6,88.5c-20.4,0-36.9-16.6-36.9-36.9C14.7,31.3,31.3,14.7,51.6,14.7z"/>
                                    </g>
                                </svg>
                            </span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="model-search">
        <div class="model-search-wrapper">
            <div class="popup-form">
                <?php get_search_form(); ?>
            </div>
        </div>
        <div class="cross-exit"></div>
    </div>

    <div id="content" class="site-content">