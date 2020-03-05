<?php
/**
 * Customize Control for Taxonomy Select.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class flash_blog_Dropdown_Taxonomies_Control extends WP_Customize_Control
{

    /**
     * Control type.
     *
     * @access public
     * @var string
     */
    public $type = 'dropdown-taxonomies';

    /**
     * Taxonomy.
     *
     * @access public
     * @var string
     */
    public $taxonomy = '';

    /**
     * Constructor.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string $id Control ID.
     * @param array $args Optional. Arguments to override class property defaults.
     */
    public function __construct($manager, $id, $args = array())
    {

        $our_taxonomy = 'category';
        if (isset($args['taxonomy'])) {
            $taxonomy_exist = taxonomy_exists(esc_attr($args['taxonomy']));
            if (true === $taxonomy_exist) {
                $our_taxonomy = esc_attr($args['taxonomy']);
            }
        }
        $args['taxonomy'] = $our_taxonomy;
        $this->taxonomy = esc_attr($our_taxonomy);

        parent::__construct($manager, $id, $args);
    }

    /**
     * Render content.
     *
     * @since 1.0.0
     */
    public function render_content()
    {

        $tax_args = array(
            'hierarchical' => 0,
            'taxonomy' => $this->taxonomy,
        );
        $all_taxonomies = get_categories($tax_args);

        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <select <?php $this->link(); ?>>
                <?php
                printf('<option value="%s" %s>%s</option>', '', selected($this->value(), '', false), ' ');
                ?>
                <?php if (!empty($all_taxonomies)) : ?>
                    <?php foreach ($all_taxonomies as $key => $tax) : ?>
                        <?php
                        printf('<option value="%s" %s>%s</option>', esc_attr($tax->term_id), selected($this->value(), $tax->term_id, false), esc_html($tax->name));
                        ?>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </label>
        <?php
    }
}


/**
 * Customize Control for Radio Image.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class flash_blog_Radio_Image_Control extends WP_Customize_Control
{

    /**
     * Control type.
     *
     * @access public
     * @var string
     */
    public $type = 'radio-image';

    /**
     * Render content.
     *
     * @since 1.0.0
     */
    public function render_content()
    {

        if (empty($this->choices)) {
            return;
        }

        $name = '_customize-radio-' . $this->id;

        ?>
        <label>
            <?php if (!empty($this->label)) : ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php endif; ?>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>

            <?php foreach ($this->choices as $value => $label) : ?>
                <label>
                    <input type="radio" value="<?php echo esc_attr($value); ?>" <?php $this->link();
                    checked($this->value(), $value); ?> class="np-radio-image" name="<?php echo esc_attr($name); ?>"/>
                    <span><img src="<?php echo esc_url($label); ?>" alt="<?php echo esc_attr($value); ?>"/></span>
                </label>
            <?php endforeach; ?>
        </label>
        <?php
    }
}

/**
 * Customizer callback functions for active_callback.
 *
 * @package Flash Blog
 */

/*select page for slider*/
if (!function_exists('flash_blog_is_select_page_slider')) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function flash_blog_is_select_page_slider($control)
    {

        if ('from-page' === $control->manager->get_setting('select_slider_from')->value()) {
            return true;
        } else {
            return false;
        }

    }

endif;

/*select cat for slider*/
if (!function_exists('flash_blog_is_select_cat_slider')) :

    /**
     * Check if slider section form page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function flash_blog_is_select_cat_slider($control)
    {

        if ('from-category' === $control->manager->get_setting('select_slider_from')->value()) {
            return true;
        } else {
            return false;
        }

    }

endif;

/**
 * Sanitization functions.
 *
 * @package Flash Blog
 */

if (!function_exists('flash_blog_sanitize_select')) :

    /**
     * Sanitize select.
     *
     * @since 1.0.0
     *
     * @param mixed $input The value to sanitize.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return mixed Sanitized value.
     */
    function flash_blog_sanitize_select($input, $setting)
    {

        // Ensure input is a slug.
        $input = sanitize_text_field($input);

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return (array_key_exists($input, $choices) ? $input : $setting->default);

    }

endif;


if (!function_exists('flash_blog_sanitize_checkbox')) :

    /**
     * Sanitize checkbox.
     *
     * @since 1.0.0
     *
     * @param bool $checked Whether the checkbox is checked.
     * @return bool Whether the checkbox is checked.
     */
    function flash_blog_sanitize_checkbox($checked)
    {

        return ((isset($checked) && true === $checked) ? true : false);

    }

endif;


if (!function_exists('flash_blog_sanitize_positive_integer')) :

    /**
     * Sanitize positive integer.
     *
     * @since 1.0.0
     *
     * @param int $input Number to sanitize.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return int Sanitized number; otherwise, the setting default.
     */
    function flash_blog_sanitize_positive_integer($input, $setting)
    {

        $input = absint($input);

        // If the input is an absolute integer, return it.
        // otherwise, return the default.
        return ($input ? $input : $setting->default);

    }

endif;

if (!function_exists('flash_blog_sanitize_dropdown_pages')) :

    /**
     * Sanitize dropdown pages.
     *
     * @since 1.0.0
     *
     * @param int $page_id Page ID.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return int|string Page ID if the page is published; otherwise, the setting default.
     */
    function flash_blog_sanitize_dropdown_pages($page_id, $setting)
    {

        // Ensure $input is an absolute integer.
        $page_id = absint($page_id);

        // If $page_id is an ID of a published page, return it; otherwise, return the default.
        return ('publish' === get_post_status($page_id) ? $page_id : $setting->default);

    }

endif;

if (!function_exists('flash_blog_sanitize_image')) :

    /**
     * Sanitize image.
     *
     * @since 1.0.0
     *
     * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
     *
     * @param string $image Image filename.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return string The image filename if the extension is allowed; otherwise, the setting default.
     */
    function flash_blog_sanitize_image($image, $setting)
    {

        /**
         * Array of valid image file types.
         *
         * The array includes image mime types that are included in wp_get_mime_types().
         */
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'bmp' => 'image/bmp',
            'tif|tiff' => 'image/tiff',
            'ico' => 'image/x-icon',
        );

        // Return an array with file extension and mime_type.
        $file = wp_check_filetype($image, $mimes);

        // If $image has a valid mime_type, return it; otherwise, return the default.
        return ($file['ext'] ? $image : $setting->default);

    }

endif;


if (!function_exists('flash_blog_sanitize_number_range')) :

    /**
     * Sanitize number range.
     *
     * @since 1.0.0
     *
     * @see absint() https://developer.wordpress.org/reference/functions/absint/
     *
     * @param int $input Number to check within the numeric range defined by the setting.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return int|string The number, if it is zero or greater and falls within the defined range; otherwise, the setting default.
     */
    function flash_blog_sanitize_number_range($input, $setting)
    {

        // Ensure input is an absolute integer.
        $input = absint($input);

        // Get the input attributes associated with the setting.
        $atts = $setting->manager->get_control($setting->id)->input_attrs;

        // Get min.
        $min = (isset($atts['min']) ? $atts['min'] : $input);

        // Get max.
        $max = (isset($atts['max']) ? $atts['max'] : $input);

        // Get Step.
        $step = (isset($atts['step']) ? $atts['step'] : 1);

        // If the input is within the valid range, return it; otherwise, return the default.
        return ($min <= $input && $input <= $max && is_int($input / $step) ? $input : $setting->default);

    }

endif;

//upselling links
/**
 * Upsell customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class flash_blog_Customize_Section_Upsell extends WP_Customize_Section {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'upsell';

    /**
     * Custom button text to output.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_text = '';

    /**
     * Custom pro button URL.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_url = '';

    /**
     * Add custom parameters to pass to the JS via JSON.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function json() {
        $json = parent::json();

        $json['pro_text'] = $this->pro_text;
        $json['pro_url']  = esc_url( $this->pro_url );

        return $json;
    }

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    protected function render_template() { ?>

        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

            <h3 class="accordion-section-title">
                {{ data.title }}

                <# if ( data.pro_text && data.pro_url ) { #>
                <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                <# } #>
            </h3>
        </li>
    <?php }
}
