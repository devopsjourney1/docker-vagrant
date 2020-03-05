<?php
if (!function_exists('flash_blog_featured_blog')):
    /**
     * Featured Blog
     *
     * @since Flash Blog 1.0.0
     *
     */
    function flash_blog_featured_blog()
    {
        if (1 != flash_blog_get_option('enable_featured_blog')) {
            return null;
        }

        $flash_blog_featured_blog_args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'cat' => absint(flash_blog_get_option('select_category_for_featured_blog')),
        ); ?>
        <section class="united-block photo-gallery-section">
        <div class="wrapper">
            <h2 class="recommended-title"><span><?php echo esc_html(flash_blog_get_option('featured_blog_title')); ?></span></h2>
        </div>
            <div class="wrapper">
            <div class="row">
            <?php $flash_blog_featured_blog_query = new WP_Query($flash_blog_featured_blog_args);
            if ($flash_blog_featured_blog_query->have_posts()) :
                while ($flash_blog_featured_blog_query->have_posts()) : $flash_blog_featured_blog_query->the_post();
                    if (has_post_thumbnail()) {
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                        $large_image = $thumb['0'];
                        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'flash-blog-720-480');
                        $small_image = $thumb['0'];
                    }else {
                        $large_image = '';
                        $small_image = '';
                    }
                    ?>
                    <div class="col col-three-1">
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="photo-grid">
                                <div class="photo-wrapper zoom-gallery">
                                    <a href="<?php echo esc_url($large_image); ?>" class="zoom-image">
                                        <?php
                                        echo '<img src="' . esc_url($small_image) . '">';
                                        ?>
                                    </a>
                                </div>
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                                    </h2>
                                    <div class="entry-meta">
                                        <?php
                                        flash_blog_posted_on();
                                        ?>
                                    </div><!-- .entry-meta -->
                                </header>
                            </div>
                        </article>
                    </div>
                    <?php
                    wp_reset_postdata();
                endwhile; ?>
                </div>
                </div>
            </section>
        <?php endif;
    }
endif;
add_action('flash_blog_action_featured_page', 'flash_blog_featured_blog', 20);

/**
 * Metabox.
 *
 * @package flash-blog
 */

if ( ! function_exists( 'flash_blog_add_meta_box' ) ) :

    /**
     * Add the Meta Box
     *
     * @since 1.0.0
     */
    function flash_blog_add_meta_box() {

        $meta_box_on = array( 'post', 'page' );

        foreach ( $meta_box_on as $meta_box_as ) {
            add_meta_box(
                'flash-blog-theme-settings',
                esc_html__( 'Layout Options', 'flash-blog' ),
                'flash_blog_render_layout_option_metabox',
                $meta_box_as,
                'side',
                'low'
            );
        }

    }

endif;

add_action( 'add_meta_boxes', 'flash_blog_add_meta_box' );

if ( ! function_exists( 'flash_blog_render_layout_option_metabox' ) ) :

    /**
     * Render theme settings meta box.
     *
     * @since 1.0.0
     */
    function flash_blog_render_layout_option_metabox( $post, $metabox ) {

        $post_id = $post->ID;
        $flash_blog_post_meta_value = get_post_meta($post_id);

        // Meta box nonce for verification.
        wp_nonce_field( basename( __FILE__ ), 'flash_blog_meta_box_nonce' );
        ?>
        <div id="pb_metabox-container" class="pb-metabox-container">
            <div id="pb-metabox-layout">
                <div class="row-content">
                    <p>
                        <div class="pb-row-content">
                            <label for="flash-blog-meta-checkbox">
                                <input type="checkbox" name="flash-blog-meta-checkbox" id="flash-blog-meta-checkbox"
                                       value="yes" <?php if (isset ($flash_blog_post_meta_value['flash-blog-meta-checkbox'])) checked($flash_blog_post_meta_value['flash-blog-meta-checkbox'][0], 'yes'); ?> />
                                <?php _e('Disable Featured Image on single page', 'flash-blog') ?>
                            </label>
                        </div>
                    </p>
                </div>
            </div>
        </div>

        <?php
    }

endif;



if ( ! function_exists( 'flash_blog_save_settings_meta' ) ) :

    /**
     * Save meta box value.
     *
     * @since 1.0.0
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post Post object.
     */
    function flash_blog_save_settings_meta( $post_id, $post ) {

        // Verify nonce.
        if ( ! isset( $_POST['flash_blog_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['flash_blog_meta_box_nonce'], basename( __FILE__ ) ) ) {
            return; }

        // Bail if auto save or revision.
        if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
            return;
        }

        // Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
        if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
            return;
        }

        // Check permission.
        if ( 'page' === $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return; }
        } else if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        $flash_blog_meta_checkbox = isset($_POST['flash-blog-meta-checkbox']) ? esc_attr($_POST['flash-blog-meta-checkbox']) : '';
        update_post_meta($post_id, 'flash-blog-meta-checkbox', sanitize_text_field($flash_blog_meta_checkbox));

    }

endif;

add_action( 'save_post', 'flash_blog_save_settings_meta', 10, 2 );