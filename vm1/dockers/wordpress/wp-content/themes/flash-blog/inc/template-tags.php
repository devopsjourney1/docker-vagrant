<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package flash_blog
 */

if (!function_exists('flash_blog_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function flash_blog_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );
        $archive_year  = get_the_time('Y'); 
        $archive_month = get_the_time('m'); 
        $archive_day   = get_the_time('d'); 
        $posted_on = sprintf(
        /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'flash-blog'),
            '<a href="' . esc_url(get_day_link( $archive_year, $archive_month, $archive_day)) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

    }
endif;

if (!function_exists('flash_blog_posted_by')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function flash_blog_posted_by()
    {
        $byline = sprintf(
        /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'flash-blog'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

    }
endif;

if (!function_exists('flash_blog_entry_footer')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function flash_blog_entry_footer()
    {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'flash-blog'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted In %1$s', 'flash-blog') . '</span>', $categories_list); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'flash-blog'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged In %1$s', 'flash-blog') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }
    }
endif;

if (!function_exists('flash_blog_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function flash_blog_post_thumbnail()
    {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>
            <?php 
            $global_layout = flash_blog_get_option('global_layout');
            if ($global_layout == 'no-sidebar'){ ?>
                <div class="zoom-gallery">
                    <a class="post-thumbnail" href="<?php the_post_thumbnail_url('full'); ?> " aria-hidden="true">
                        <?php
                        the_post_thumbnail('flash-blog-full-1200-900', array(
                            'alt' => the_title_attribute(array(
                                'echo' => false,
                            )),
                        ));
                        ?>
                    </a>
                </div>
            <?php } else { ?>
            <div class="zoom-gallery">
                <a class="post-thumbnail" href="<?php the_post_thumbnail_url('full'); ?> " aria-hidden="true">
                    <?php
                    the_post_thumbnail('flash-blog-full-800-600', array(
                        'alt' => the_title_attribute(array(
                            'echo' => false,
                        )),
                    ));
                    ?>
                </a>
            </div>
        <?php } ?>
        <?php endif; // End is_singular().
    }
endif;
