<?php
require_once get_theme_file_path('/inc/tgm.php');
if (class_exists('Attachments')) {
    require_once "lib/attachments.php";
}
?>
<?php
if (site_url() == "http://localhost/wp") {
    define("VERSION", time());
} else {
    define("VERSION", wp_get_theme()->get("Version"));
}


function alpha_bootstraping()
{
    load_theme_textdomain("alpha");
    add_theme_support("post-thumbnails");
    add_theme_support("title-tag");
    add_theme_support('html5', array('search-form'));
    $alpha_custom_header_details = array(
        'header-text' => true,
        'default-text-color' => '#222',
        'width' => 1200,
        'height' => 600,
        'flex-height' => true,
        'flex-width' => true
    );
    add_theme_support('custom-header', $alpha_custom_header_details);
    $alpha_custom_logo_defaults = array(
        'height'      => 100,
        'width'       => 400,
        // 'flex-height' => true,
        // 'flex-width'  => true,
        // 'header-text' => array('site-title', 'site-description')
    );
    add_theme_support('custom-logo', $alpha_custom_logo_defaults);
    add_theme_support('custom-background');
    register_nav_menu("topmenu", __("Top Menu", "alpha"));
    register_nav_menu("footermenu", __("Footer Menu", "alpha"));
    add_theme_support('post-formats', array("aside", "link", "gallery", "image", "quote", "video", "audio"));
    add_image_size('alpha-square', 400, 400, true); // center center most developer use this
    add_image_size('alpha-portrait', 400, 9999);
    add_image_size('alpha-landscape', 9999, 400);
    add_image_size('alpha-landscape-hard-cropped', 600, 400);
}

add_action("after_setup_theme", "alpha_bootstraping");

function alpha_assets()
{
    wp_enqueue_style("bootstrap", "//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
    wp_enqueue_style("featherlight-css", "//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css");
    wp_enqueue_style('dashicons');
    wp_enqueue_style("tns-style", "//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css");
    wp_enqueue_style("alpha", get_stylesheet_uri(), null, VERSION);
    wp_enqueue_script("featherlight-js", "//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js", array('jquery'), null, true);
    wp_enqueue_script("tns-js", "//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js", null, "0.0.1", true);
    wp_enqueue_style("alpha-style", get_template_directory_uri() . "/assets/css/alpha.css");
    wp_enqueue_script("alpha-main",  get_theme_file_uri() . "/assets/js/main.js", array("jquery", "featherlight-js"), VERSION, true);
}
add_action("wp_enqueue_scripts", "alpha_assets");

function alpha_sidebar()
{
    register_sidebar(array(
        'name' => __('Single Post Sidebar', 'alpha'),
        'id' => 'sidebar-1',
        'description' => __('Right Sidebar', 'alpha'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer Left', 'alpha'),
        'id' => 'footer-left',
        'description' => __('Widgetized area on left side', 'alpha'),
        'before_widget' => '<section id="%1s" class="widget %2s">',
        'after_widget' => '</section>',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Footer Right', 'alpha'),
        'id' => 'footer-right',
        'description' => __('Widgetized area on right side', 'alpha'),
        'before_widget' => '<section id="%1s" class="widget %2s">',
        'after_widget' => '</section>',
        'before_title' => '',
        'after_title' => '',
    ));
}

add_action("widgets_init", "alpha_sidebar");

function alpha_the_excerpt($excerpt)
{
    if (!post_password_required()) {
        return $excerpt;
    } else {
        echo get_the_password_form();
    }
}
add_filter("the_excerpt", "alpha_the_excerpt");
function alpha_protected_title_change()
{
    return "Locked: %s";
}
add_filter("protected_title_format", "alpha_protected_title_change");
function alpha_menu_item_class($classes, $item)
{
    $classes[] = "list-inline-item";
    return $classes;
}
apply_filters('nav_menu_css_class', 'alpha_menu_item_class', 10, 2);

if (!function_exists("alpha_about_page_template_banner")) {
    function alpha_about_page_template_banner()
    {
        if (is_page()) {
            $alpha_feat_image = get_the_post_thumbnail_url(null, "large"); ?>
            <style>
                .page-header {
                    background-image: url(<?php echo $alpha_feat_image; ?>);
                }
            </style>
            <?php
        }

        if (is_front_page()) {
            if (current_theme_supports("custom-header")) {
            ?>
                <style>
                    .header {
                        background-image: url(<?php header_image(); ?>);
                        background-size: cover;
                        margin-bottom: 50px;
                    }

                    .header h1.heading a,
                    h3.tagline {
                        color: #<?php echo get_header_textcolor(); ?>;
                        <?php
                        if (!display_header_text()) {
                            echo "display:none";
                        }
                        ?>
                    }
                </style>
<?php
            }
        }
    }
}
add_action("wp_head", "alpha_about_page_template_banner", 11);
?>
<?php
function alpha_highlight_search_results($text)
{
    if (is_search()) {
        $pattern = '/(' . join('|', explode(' ', get_search_query())) . ')/i';
        $text = preg_replace($pattern, '<span class="search-highlight">\0</span>', $text);
    }
    return $text;
}
add_filter('the_content', 'alpha_highlight_search_results');
add_filter('the_excerpt', 'alpha_highlight_search_results');
add_filter('the_title', 'alpha_highlight_search_results');

//function alpha_image_srcset(){
//    return null;
//}
//add_filter("wp_calculate_image_srcset","alpha_image_srcset");
add_filter("wp_calculate_image_srcset", "__return_null");

if (!function_exists("alpha_todays_date")) {
    function alpha_todays_date()
    {
        echo date("d/m/Y");
    }
}
function alpha_modify_main_query($wpq)
{
    if (is_home() && $wpq->is_main_query()) {
        $wpq->set("tag__not_in", array(2));
    }
}
add_action("pre_get_posts", "alpha_modify_main_query");
