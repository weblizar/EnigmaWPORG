<?php
/** Theme Name    : Enigma
 * Theme Core Functions and Codes
 */

/* Get the plugin */
if ( ! function_exists( 'wl_theme_is_companion_active' ) ) {
    function wl_theme_is_companion_active() {
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( is_plugin_active(  'weblizar-companion/weblizar-companion.php' ) ) {
            return true;
        } else {
            return false;
        }
    }
}

/**Includes required resources here**/
require(get_template_directory() . '/core/menu/default_menu_walker.php');
require(get_template_directory() . '/core/menu/enigma_nav_walker.php');
require(get_template_directory() . '/core/scripts/css_js.php'); //Enquiring Resources here
require(get_template_directory() . '/core/comment-function.php');
require(get_template_directory() . '/core/custom-header.php');
require(get_template_directory() . '/class-tgm-plugin-activation.php');

/*After Theme Setup*/
add_action('after_setup_theme', 'enigma_head_setup');

function enigma_head_setup()
{
    global $content_width;
    //content width
    if (!isset($content_width)) $content_width = 550; //px

    /* Enable support for Woocommerce */
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    //Blog Thumb Image Sizes
    add_image_size('home_post_thumb', 340, 210, true);
    //Blogs thumbs
    add_image_size('wl_page_thumb', 730, 350, true);
    add_image_size('blog_2c_thumb', 570, 350, true);
    add_theme_support('title-tag');

    // Logo
    add_theme_support('custom-logo', array(
        'width' => 250,
        'height' => 250,
        'flex-width' => true,
        'flex-height' => true,
    ));

    // Load text domain for translation-ready
    load_theme_textdomain('enigma', get_template_directory() . '/core/lang');

    add_theme_support('post-thumbnails'); //supports featured image
    // This theme uses wp_nav_menu() in one location.
    register_nav_menu('primary', __('Primary Menu', 'enigma'));

    // theme support
    $args = array('default-color' => '000000');
    add_theme_support('custom-background', $args);
    add_theme_support('automatic-feed-links');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('customize-selective-refresh-widgets');

    /* Allow shortcodes in widgets. */
    add_filter('widget_text', 'do_shortcode');

    /* Gutenberg */
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('customize-selective-refresh-widgets');

    /* Add editor style. */
    add_theme_support('editor-styles');
    add_theme_support('dark-editor-style');

    /* Enable support for HTML5 */
    add_theme_support('html5',
        array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, icons, and column width.
    */
    add_editor_style('css/editor-style.css');
}


// Read more tag to formatting in blog page
function enigma_content_more($more)
{
    return wp_kses_post('<div class="blog-post-details-item"><a class="enigma_blog_read_btn" href="' . get_permalink() . '"><i class="fa fa-plus-circle"></i>"' . __('Read More', 'enigma') . '"</a></div>');
}

add_filter('the_content_more_link', 'enigma_content_more');


// Replaces the excerpt "more" text by a link
function enigma_excerpt_more($more)
{
    return '';
}

add_filter('excerpt_more', 'enigma_excerpt_more');

/*
* Enigma widget area
*/
add_action('widgets_init', 'enigma_widgets_init');
function enigma_widgets_init()
{
    /*sidebar*/
    register_sidebar(array(
        'name' => __('Sidebar', 'enigma'),
        'id' => 'sidebar-primary',
        'description' => __('The primary widget area', 'enigma'),
        'before_widget' => '<div class="enigma_sidebar_widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="enigma_sidebar_widget_title"><h2>',
        'after_title' => '</h2></div>'
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area', 'enigma'),
        'id' => 'footer-widget-area',
        'description' => __('footer widget area', 'enigma'),
        'before_widget' => '<div class="col-md-3 col-sm-6 enigma_footer_widget_column %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="enigma_footer_widget_title">',
        'after_title' => '<div class="enigma-footer-separator"></div></div>',
    ));
}


/* Breadcrumbs  */
function enigma_breadcrumbs()
{
    $delimiter = '';
    $home = __('Home', 'enigma'); // text for the 'Home' link
    $before = '<li>'; // tag before the current crumb
    $after = '</li>'; // tag after the current crumb
    echo '<ul class="breadcrumb">';
    global $post;
    $homeLink = home_url();
    echo '<li><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a></li>' . $delimiter . ' ';
    if (is_category()) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
        if ($thisCat->parent != 0)
            echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
        echo $before . ' esc_html__("Archive by category","enigma") "' . single_cat_title('', false) . '"' . $after;
    } elseif (is_day()) {
        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('d') . $after;
    } elseif (is_month()) {
        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('F') . $after;
    } elseif (is_year()) {
        echo $before . get_the_time('Y') . $after;
    } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
            echo $before . esc_html(get_the_title()) . $after;
        } else {
            $cat = get_the_category();
            $cat = $cat[0];
            //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo $before . esc_html(get_the_title()) . $after;
        }

    } elseif (!is_single() && !is_page() && get_post_type() != 'post') {
        $post_type = get_post_type_object(get_post_type());
        echo $before . $post_type->labels->singular_name . $after;
    } elseif (is_attachment()) {
        $parent = get_post($post->post_parent);
        $cat = get_the_category($parent->ID);
        //$cat = $cat[0];
        // echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li> ' . $delimiter . ' ';
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_page() && !$post->post_parent) {
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_page() && $post->post_parent) {
        $parent_id = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . esc_html(get_the_title($page->ID)) . '</a></li>';
            $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb)
            echo $crumb . ' ' . $delimiter . ' ';
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_search()) {
        echo $before . esc_html__("Search results for", "enigma") . get_search_query() . '"' . $after;

    } elseif (is_tag()) {
        echo $before . esc_html__('Tag', 'enigma') . single_tag_title('', false) . $after;
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo $before . esc_html__("Articles posted by", "enigma") . $userdata->display_name . $after;
    } elseif (is_404()) {
        echo $before . esc_html__("Error 404", "enigma") . $after;
    }

    echo '</ul>';
}

/*===================================================================================
* Add Class Gravtar
* =================================================================================*/
add_filter('get_avatar', 'enigma_gravatar_class');

function enigma_gravatar_class($class)
{
    $class = str_replace("class='avatar", "class='author_detail_img", $class);
    return $class;
}



//Plugin Recommend
add_action('tgmpa_register', 'enigma_plugin_recommend');

function enigma_plugin_recommend()
{
    $plugins = array(
        array(
            'name' => 'Weblizar Companion',
            'slug' => 'weblizar-companion',
            'required' => false,
        ),

    );
    tgmpa($plugins);
}

add_action('wp_enqueue_scripts', 'enigna_parallax_custom_css');
function enigna_parallax_custom_css()
{
    $output = '';
    
    $output     .='
    .logo img{
        height:'.esc_attr(get_theme_mod('logo_height','55')).'px;
        width:'.esc_attr(get_theme_mod('logo_width','150')).'px;
    }';
    //custom css
    $custom_css = get_theme_mod('custom_css') ; 
    if (!empty ($custom_css)) {
        $output .= get_theme_mod('custom_css') . "\n";
    }

    wp_register_style('custom-header-style', false);
    wp_enqueue_style('custom-header-style', get_template_directory_uri() . '/css/custom-header-style.css');
    wp_add_inline_style('custom-header-style', $output);
}
?>