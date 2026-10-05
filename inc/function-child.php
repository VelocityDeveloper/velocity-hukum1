<?php

/**
 * Fuction yang digunakan di theme ini.
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


add_action('after_setup_theme', 'velocitychild_theme_setup', 9);
function velocitychild_theme_setup()
{

	// Load justg_child_enqueue_parent_style after theme setup
	add_action('wp_enqueue_scripts', 'justg_child_enqueue_parent_style', 20);

	// Pengaturan Customizer ada di inc/customizer.php (tanpa Kirki).

	//remove action from Parent Theme
	remove_action('justg_header', 'justg_header_menu');
	remove_action('justg_do_footer', 'justg_the_footer_open');
	remove_action('justg_do_footer', 'justg_the_footer_content');
	remove_action('justg_do_footer', 'justg_the_footer_close');
	remove_theme_support('widgets-block-editor');
}


///remove breadcrumbs
add_action('wp_head', function () {
	if (!is_single()) {
		remove_action('justg_before_title', 'justg_breadcrumb');
	}
});

if (!function_exists('justg_header_open')) {
    function justg_header_open()
    {
        echo '<header class="bg-theme-secondary shadow shadow-sm" id="wrapper-header" itemscope itemtype="http://schema.org/WebSite">';
    }
}
if (!function_exists('justg_header_close')) {
    function justg_header_close()
    {
        echo '</header>';
    }
}

///add action builder part
add_action('justg_header', 'justg_header_berita');
function justg_header_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-header.php');
}
add_action('justg_do_footer', 'justg_footer_berita');
function justg_footer_berita()
{
	require_once(get_stylesheet_directory() . '/inc/part-footer.php');
}

// excerpt more
if ( ! function_exists( 'velocity_custom_excerpt_more' ) ) {
	function velocity_custom_excerpt_more( $more ) {
		return '...';
	}
}
add_filter( 'excerpt_more', 'velocity_custom_excerpt_more' );

// excerpt length
function velocity_excerpt_length($length){
	return 20;
}
add_filter('excerpt_length','velocity_excerpt_length');


//register widget
add_action('widgets_init', 'justg_widgets_init', 20);
if (!function_exists('justg_widgets_init')) {
	function justg_widgets_init()
	{
		$text_theme = 'justg';
		$before_widget = '<aside id="%1$s" class="widget %2$s">';
		$after_widget = '</aside>';
		$before_title = '<h6 class="widget-title position-relative mb-3">';
		$after_title = '</h6>';
		register_sidebar(
			array(
				'name'          => __('Main Sidebar', $text_theme),
				'id'            => 'main-sidebar',
				'description'   => __('Main sidebar widget area', $text_theme),
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title,
				'show_in_rest'   => false,
			)
		);
		// Register footer widget area
		register_sidebar(
			array(
				'name'          => __( 'Footer Widget Area 1', 'justg' ),
				'id'            => 'footer-widget-1',
				'description'   => __( '', 'justg' ),
				'before_widget' => '<aside id="%1$s" class="mb-4 widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title"><span>',
				'after_title'   => '</span></h6>',
			)
		);
		register_sidebar(
			array(
				'name'          => __( 'Footer Widget Area 2', 'justg' ),
				'id'            => 'footer-widget-2',
				'description'   => __( '', 'justg' ),
				'before_widget' => '<aside id="%1$s" class="mb-4 widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title"><span>',
				'after_title'   => '</span></h6>',
			)
		);
		register_sidebar(
			array(
				'name'          => __( 'Footer Widget Area 3', 'justg' ),
				'id'            => 'footer-widget-3',
				'description'   => __( '', 'justg' ),
				'before_widget' => '<aside id="%1$s" class="mb-4 widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h6 class="widget-title"><span>',
				'after_title'   => '</span></h6>',
			)
		);
	}
}
if (!function_exists('justg_right_sidebar_check')) {
	function justg_right_sidebar_check()
	{
		if (is_singular('fl-builder-template')) {
			return;
		}
		if (!is_active_sidebar('main-sidebar')) {
			return;
		}
		echo '<div class="right-sidebar velocity-widget widget-area col-sm-12 col-md-4 order-3" id="right-sidebar" role="complementary">';
		do_action('justg_before_main_sidebar');
		dynamic_sidebar('main-sidebar');
		do_action('justg_after_main_sidebar');
		echo '</div>';
	}
}
