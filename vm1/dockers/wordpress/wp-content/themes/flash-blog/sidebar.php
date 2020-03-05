<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package flash_blog
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
$global_layout = flash_blog_get_option('global_layout');
if ($global_layout == 'no-sidebar'){
    return;
}
?>

<aside id="secondary" class="widget-area">
    <div class="theiaStickySidebar">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</aside><!-- #secondary -->
