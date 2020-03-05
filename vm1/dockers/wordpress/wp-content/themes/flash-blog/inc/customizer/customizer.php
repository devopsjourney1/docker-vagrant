<?php
/**
 * Flash Blog Theme Customizer.
 *
 * @package Flash Blog
 */

/**
 * Core functions.
 *
 */

if (!function_exists('flash_blog_get_option')):

/**
 * Get theme option.
 *
 * @since 1.0.0
 *
 * @param string $key Option key.
 * @return mixed Option value.
 */
function flash_blog_get_option($key) {

	if (empty($key)) {
		return;
	}

	$value = '';

	$default       = flash_blog_get_default_theme_options();
	$default_value = null;

	if (is_array($default) && isset($default[$key])) {
		$default_value = $default[$key];
	}

	if (null !== $default_value) {
		$value = get_theme_mod($key, $default_value);
	} else {
		$value = get_theme_mod($key);
	}

	return $value;
}
endif;
//customizer default
require get_template_directory().'/inc/customizer/default.php';
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function flash_blog_customize_register($wp_customize) {

	// Load custom controls.
	require get_template_directory().'/inc/customizer/customizer-function.php';

	$wp_customize->get_setting('blogname')->transport        = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial('blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'flash_blog_customize_partial_blogname',
			));
		$wp_customize->selective_refresh->add_partial('blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'flash_blog_customize_partial_blogdescription',
			));
	}
	/*theme option panel details*/
	require get_template_directory().'/inc/customizer/theme-option.php';
    // Register custom section types.
    $wp_customize->register_section_type( 'flash_blog_Customize_Section_Upsell' );

// Register sections.
    $wp_customize->add_section(new flash_blog_Customize_Section_Upsell(
            $wp_customize,
            'theme_upsell',
            array(
                'title'    => esc_html__( 'Flash Blog Plus', 'flash-blog' ),
                'pro_text' => esc_html__( 'Buy Pro', 'flash-blog' ),
                'pro_url'  => 'https://unitedtheme.com/themes/flash-blog-plus/',
                'priority'  => 1,
            )
        )
    );

}

add_action('customize_register', 'flash_blog_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.0.0
 */
function flash_blog_customize_preview_js() {

	wp_enqueue_script('flash_blog_customizer', get_template_directory_uri().'/js/customizer.js', array('customize-preview'), '20130508', true);

}

add_action('customize_preview_init', 'flash_blog_customize_preview_js');

function flash_blog_upsell_js() {
    wp_enqueue_script( 'flash_blog_customize_controls', get_template_directory_uri() . '/assets/js/upsell.js', array( 'customize-controls' ) );
}
add_action( 'customize_controls_enqueue_scripts', 'flash_blog_upsell_js',0 );