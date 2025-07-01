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

	if (class_exists('Kirki')) :

		$text_theme = 'justg';

		Kirki::add_panel('panel_velocity', [
			'priority'    => 10,
			'title'       => esc_html__('Velocity Theme', $text_theme),
			'description' => esc_html__('', $text_theme),
		]);

		// section title_tagline
		Kirki::add_section('title_tagline', [
			'panel'    => 'panel_velocity',
			'title'    => __('Site Identity', $text_theme),
			'priority' => 10,
		]);

		///Section Color
		Kirki::add_section('section_colorvelocity', [
			'panel'    => 'panel_velocity',
			'title'    => __('Color & Background', $text_theme),
			'priority' => 10,
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme',
			'label'       => __('Primary Theme Color', $text_theme),
			'description' => esc_html__('', $text_theme),
			'section'     => 'section_colorvelocity',
			'default'     => '#583207',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme',
				],
				[
					'element'   => ':root',
					'property'  => '--bs-primary',
				],
				[
					'element'   => '.border-color-theme',
					'property'  => '--bs-border-color',
				]
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'color',
			'settings'    => 'color_theme2',
			'label'       => __('Secondary Theme Color', $text_theme),
			'description' => esc_html__('', $text_theme),
			'section'     => 'section_colorvelocity',
			'default'     => '#ca9e68',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root',
					'property'  => '--color-theme-secondary',
				],
				[
					'element'   => ':root',
					'property'  => '--bs-secondary',
				]
			],
		]);
		Kirki::add_field('justg_config', [
			'type'        => 'background',
			'settings'    => 'background_themewebsite',
			'label'       => __('Website Background', $text_theme),
			'description' => esc_html__('', $text_theme),
			'section'     => 'section_colorvelocity',
			'default'     => [
				'background-color'      => 'rgba(255,255,255)',
				'background-image'      => '',
				'background-repeat'     => 'repeat',
				'background-position'   => 'center center',
				'background-size'       => 'cover',
				'background-attachment' => 'scroll',
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element'   => ':root[data-bs-theme=light] body',
				],
				[
					'element'   => 'body',
				],
			],
		]);


        /**
         * SECTION: Top Home
         */
		Kirki::add_section( 'top_home_section', [
			'title'    => esc_html__( 'Top Home', $text_theme ),
			'priority' => 20,
			'panel'    => 'panel_velocity',
		] );
		Kirki::add_field( 'justg_config', [
			'type'        => 'image',
			'settings'    => 'hero_gambar',
			'label'       => esc_html__( 'Gambar Hero', $text_theme ),
			'section'     => 'top_home_section',
			'default'     => '',
			'description' => 'Ukuran rekomendasi: 800x1000px (portrait)',
		] );
		Kirki::add_field( 'justg_config', [
			'type'     => 'text',
			'settings' => 'hero_slogan',
			'label'    => esc_html__( 'Slogan', $text_theme ),
			'section'  => 'top_home_section',
			'default'  => get_bloginfo('description'),
		] );

		Kirki::add_field( 'justg_config', [
			'type'     => 'text',
			'settings' => 'hero_judul',
			'label'    => esc_html__( 'Judul Utama', $text_theme ),
			'section'  => 'top_home_section',
			'default'  => get_bloginfo('name'),
		] );

		Kirki::add_field( 'justg_config', [
			'type'        => 'editor',
			'settings'    => 'hero_deskripsi',
			'label'       => esc_html__( 'Deskripsi Singkat', $text_theme ),
			'section'     => 'top_home_section',
			'media_buttons' => false,
		] );



		// SECTION: keunggulan
		Kirki::add_section( 'keunggulan_section', [
			'title'    => esc_html__( 'Halaman Depan - Keunggulan', $text_theme ),
			'priority' => 50,
			'panel'    => 'panel_velocity',
		] );
        Kirki::add_field('justg_config', [
            'type'     => 'text',
            'settings' => 'judul_keunggulan',
            'label'    => esc_html__('Judul', $text_theme),
            'section'  => 'keunggulan_section',
            'default'  => 'Mengapa Memilih Kami?',
        ]);

		Kirki::add_field( 'theme_config_id', [
			'type'        => 'repeater',
			'settings'    => 'keunggulan_items',
			'label'       => esc_html__( 'Daftar Keunggulan', $text_theme ),
			'section'     => 'keunggulan_section',
			'priority'    => 10,
			'row_label'   => [
				'type'  => 'text',
				'value' => esc_html__( 'Keunggulan', $text_theme ),
				'field' => 'nama',
			],
			'fields'      => [
				'icon' => [
					'type'        => 'text',
					'label'       => esc_html__( 'Icon', $text_theme ),
					'default'     => 'hand-thumbs-up',
					'description' => 'Isi dengan nama icon,<br/>daftar icon <a href="https://icons.getbootstrap.com/#icons-list" target="_blank"><b>klik disini</b></a>.',
					'placeholder' => esc_html__( 'Masukkan nama class icon Bootstrap', $text_theme ),
				],
				'nama' => [
					'type'        => 'text',
					'label'       => esc_html__( 'Nama', $text_theme ),
					'default'     => '',
					'placeholder' => esc_html__( 'Masukkan nama keunggulan', $text_theme ),
				],
				'deskripsi' => [
					'type'        => 'textarea',
					'label'       => esc_html__( 'Deskripsi', $text_theme ),
					'default'     => '',
					'placeholder' => esc_html__( 'Masukkan deskripsi singkat', $text_theme ),
				],
			],
			'button_label' => esc_html__( 'Tambah Keunggulan', $text_theme ),
			'default'     => [],
		]);


		// SECTION: Layanan
		Kirki::add_section( 'layanan_section', [
			'title'    => esc_html__( 'Halaman Depan - Layanan', $text_theme ),
			'priority' => 50,
			'panel'    => 'panel_velocity',
		] );
        Kirki::add_field('justg_config', [
            'type'     => 'text',
            'settings' => 'judul_layanan',
            'label'    => esc_html__('Judul', $text_theme),
            'section'  => 'layanan_section',
            'default'  => 'Layanan Kami',
			'priority'    => 10,
        ]);

		Kirki::add_field( 'theme_config_id', [
			'type'        => 'repeater',
			'settings'    => 'layanan_items',
			'label'       => esc_html__( 'Daftar Layanan', $text_theme ),
			'section'     => 'layanan_section',
			'row_label'   => [
				'type'  => 'text',
				'value' => esc_html__( 'Layanan', $text_theme ),
				'field' => 'nama',
			],
			'fields'      => [
				'icon' => [
					'type'        => 'text',
					'label'       => esc_html__( 'Icon', $text_theme ),
					'default'     => 'hand-thumbs-up',
					'description' => 'Isi dengan nama icon,<br/>daftar icon <a href="https://icons.getbootstrap.com/#icons-list" target="_blank"><b>klik disini</b></a>.',
					'placeholder' => esc_html__( 'Masukkan nama class icon Bootstrap', $text_theme ),
				],
				'nama' => [
					'type'        => 'text',
					'label'       => esc_html__( 'Nama', $text_theme ),
					'default'     => '',
					'placeholder' => esc_html__( 'Masukkan nama layanan', $text_theme ),
				],
				'deskripsi' => [
					'type'        => 'textarea',
					'label'       => esc_html__( 'Deskripsi', $text_theme ),
					'default'     => '',
					'placeholder' => esc_html__( 'Masukkan deskripsi singkat', $text_theme ),
				],
			],
			'button_label' => esc_html__( 'Tambah Layanan', $text_theme ),
			'default'     => [],
			'priority'    => 11,
		]);

		Kirki::add_field( 'justg_config', [
			'type'        => 'custom',
			'settings'    => 'info_tombol_layanan',
			'section'     => 'layanan_section',
			'default'     => '<hr><h3 style="margin:0;">Tombol Layanan</h3>',
			'priority'    => 12,
		] );
        Kirki::add_field('justg_config', [
            'type'     => 'text',
            'settings' => 'teks_link_layanan',
            'label'    => esc_html__('Teks Link', $text_theme),
            'section'  => 'layanan_section',
            'default'  => 'Lihat Semua Layanan',
			'priority'    => 12,
        ]);
		Kirki::add_field('justg_config', [
			'type'     => 'link',
			'settings' => 'link_layanan',
			'label'    => esc_html__('Link Layanan', $text_theme),
			'section'  => 'layanan_section',
			'description' => 'Masukkan URL lengkap (contoh: https://contoh.com/layanan)',
			'priority'    => 12,
		]);

		// SECTION: Konsultasi
		Kirki::add_section( 'konsultasi_section', [
			'title'    => esc_html__( 'Halaman Depan - Konsultasi', $text_theme ),
			'priority' => 60,
			'panel'    => 'panel_velocity',
		] );

		// Sub-section: Konsultasi 1
		Kirki::add_field( 'justg_config', [
			'type'        => 'custom',
			'settings'    => 'info_konsultasi1',
			'section'     => 'konsultasi_section',
			'default'     => '<h3 style="margin:0;">Konsultasi 1</h3>',
			'priority'    => 10,
		] );

		// Field Gambar
		Kirki::add_field( 'justg_config', [
			'type'        => 'image',
			'settings'    => 'gambar_konsultasi1',
			'label'       => esc_html__( 'Gambar', $text_theme ),
			'section'     => 'konsultasi_section',
			'priority'    => 10, 
			'description' => 'Ukuran rekomendasi: 600x400 px',
		] );

		// Judul Konsultasi 1
		Kirki::add_field( 'justg_config', [
			'type'     => 'text',
			'settings' => 'judul_konsultasi1',
			'label'    => esc_html__( 'Judul Konsultasi 1', $text_theme ),
			'section'  => 'konsultasi_section',
			'default'  => 'Konsultasi Online',
			'priority' => 10,
		] );


		// Keterangan Ketentuan 1
		Kirki::add_field( 'justg_config', [
			'type'        => 'editor',
			'settings'    => 'ket_konsultasi1',
			'label'       => esc_html__( 'Keterangan', $text_theme ),
			'section'     => 'konsultasi_section',
			'media_buttons' => false,
			'priority'    => 10,
		] );

		// Sub-section: Konsultasi 2
		Kirki::add_field( 'justg_config', [
			'type'        => 'custom',
			'settings'    => 'info_konsultasi2',
			'section'     => 'konsultasi_section',
			'default'     => '<hr><h3 style="margin:0;">Konsultasi 2</h3>',
			'priority'    => 10,
		] );		

		// Field Gambar
		Kirki::add_field( 'justg_config', [
			'type'        => 'image',
			'settings'    => 'gambar_konsultasi2',
			'label'       => esc_html__( 'Gambar', $text_theme ),
			'section'     => 'konsultasi_section',
			'priority'    => 10, // Sesuaikan urutan (misal setelah judul)
			'description' => 'Ukuran rekomendasi: 600x400 px',
		] );

		// Judul Konsultasi 2
		Kirki::add_field( 'justg_config', [
			'type'     => 'text',
			'settings' => 'judul_konsultasi2',
			'label'    => esc_html__( 'Judul Konsultasi 2', $text_theme ),
			'section'  => 'konsultasi_section',
			'default'  => 'Konsultasi Tatap Muka',
			'priority' => 10,
		] );

		// Keterangan Ketentuan 2
		Kirki::add_field( 'justg_config', [
			'type'        => 'editor',
			'settings'    => 'ket_konsultasi2',
			'label'       => esc_html__( 'Keterangan', $text_theme ),
			'section'     => 'konsultasi_section',
			'media_buttons' => false,
			'priority'    => 10,
		] );

		// Sub-section: Tombol WhatsApp
		Kirki::add_field( 'justg_config', [
			'type'        => 'custom',
			'settings'    => 'info_tombolwa',
			'section'     => 'konsultasi_section',
			'default'     => '<hr><h3 style="margin:0;">Tombol WhatsApp</h3>',
			'priority'    => 10,
		] );

		// Tombol WhatsApp
		Kirki::add_field( 'justg_config', [
			'type'     => 'text',
			'settings' => 'wa_konsultasi',
			'label'    => esc_html__( 'Nomor WhatsApp', $text_theme ),
			'section'  => 'konsultasi_section',
			'default'  => '',
			'description' => esc_html__( 'Contoh: 08123456789', $text_theme ),
			'priority' => 10,
		] );

		// Teks Tombol
		Kirki::add_field( 'justg_config', [
			'type'     => 'text',
			'settings' => 'teks_tombol_konsultasi',
			'label'    => esc_html__( 'Teks Tombol', $text_theme ),
			'section'  => 'konsultasi_section',
			'default'  => 'Konsultasi Sekarang',
			'priority' => 10,
		] );

		// remove panel in customizer 
		Kirki::remove_panel('global_panel');
		Kirki::remove_panel('panel_header');
		Kirki::remove_panel('panel_footer');
		Kirki::remove_panel('panel_antispam');
		Kirki::remove_control('display_header_text');
        Kirki::remove_section('header_image');
        Kirki::remove_section('header_section');

	endif;

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
