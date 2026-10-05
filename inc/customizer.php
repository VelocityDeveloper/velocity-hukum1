<?php
/**
 * Pengaturan Hukum 1 di Customizer bawaan WordPress (tanpa Kirki).
 *
 * Nama theme mod sama dengan versi Kirki (color_theme, color_theme2,
 * background_themewebsite, hero_*, judul_keunggulan, keunggulan_items,
 * judul_layanan, layanan_items, teks_link_layanan, link_layanan, *_konsultasi*,
 * wa_konsultasi) supaya nilai yang sudah tersimpan tetap terbaca.
 * background_themewebsite, keunggulan_items dan layanan_items tetap satu array;
 * tiap kontrol menyimpan satu kuncinya.
 *
 * @package justg
 */

defined('ABSPATH') || exit;

const VELOCITY_HUKUM1_WARNA = '#583207';
const VELOCITY_HUKUM1_WARNA2 = '#ca9e68';
const VELOCITY_HUKUM1_SLOT_MIN = 6;

/**
 * Nilai bawaan pengaturan halaman depan (sama dengan default Kirki dulu).
 */
function velocity_hukum1_bawaan()
{
    return [
        'hero_slogan'            => get_bloginfo('description'),
        'hero_judul'             => get_bloginfo('name'),
        'judul_keunggulan'       => 'Mengapa Memilih Kami?',
        'judul_layanan'          => 'Layanan Kami',
        'teks_link_layanan'      => 'Lihat Semua Layanan',
        'judul_konsultasi1'      => 'Konsultasi Online',
        'judul_konsultasi2'      => 'Konsultasi Tatap Muka',
        'teks_tombol_konsultasi' => 'Konsultasi Sekarang',
    ];
}

/**
 * Nilai theme mod dengan bawaan di atas. Kirki dulu mengisi bawaan ini otomatis.
 */
function velocity_hukum1_mod($nama)
{
    $bawaan = velocity_hukum1_bawaan();
    return get_theme_mod($nama, isset($bawaan[$nama]) ? $bawaan[$nama] : '');
}

/**
 * URL gambar dari theme mod. Kirki bisa menyimpan id lampiran, bukan URL.
 */
function velocity_hukum1_gambar($nama)
{
    $gambar = get_theme_mod($nama, '');
    if (is_numeric($gambar)) {
        $gambar = wp_get_attachment_url((int) $gambar);
    }
    return $gambar ? $gambar : '';
}

/**
 * Baris keunggulan_items / layanan_items yang terisi, urut sesuai Customizer.
 * Slot tanpa nama dan deskripsi dilewati.
 */
function velocity_hukum1_daftar($nama)
{
    $baris = get_theme_mod($nama, []);
    $hasil = [];
    foreach (is_array($baris) ? $baris : [] as $item) {
        if (!is_array($item)) {
            continue;
        }
        $item = array_merge(['icon' => '', 'nama' => '', 'deskripsi' => ''], $item);
        if (trim($item['nama']) === '' && trim($item['deskripsi']) === '') {
            continue;
        }
        $hasil[] = $item;
    }
    return $hasil;
}

/**
 * Nilai bawaan latar website (sama dengan default Kirki dulu).
 */
function velocity_hukum1_latar_bawaan()
{
    return [
        'background-color'      => '#ffffff',
        'background-image'      => '',
        'background-repeat'     => 'repeat',
        'background-position'   => 'center center',
        'background-size'       => 'cover',
        'background-attachment' => 'scroll',
    ];
}

/**
 * Warna hex, atau rgb()/rgba() yang dulu bisa disimpan Kirki.
 */
function velocity_hukum1_sanitize_warna($warna)
{
    $warna = trim((string) $warna);
    if (preg_match('/^rgba?\(\s*[\d.\s,%]+\)$/i', $warna)) {
        return $warna;
    }
    return sanitize_hex_color($warna) ?: '';
}

/**
 * Warna hex ke "r,g,b" untuk variabel --bs-*-rgb.
 */
function velocity_hukum1_rgb($warna)
{
    $hex = ltrim($warna, '#');
    if (strlen($hex) === 3) {
        $hex = preg_replace('/([0-9a-f])/i', '$1$1', $hex);
    }
    return implode(',', array_map('hexdec', str_split($hex, 2)));
}

add_action('customize_register', function ($wp_customize) {
    /**
     * Judul pemisah di dalam satu bagian (pengganti kontrol "custom" Kirki).
     */
    class Velocity_Hukum1_Judul_Control extends WP_Customize_Control
    {
        public $type = 'velocity_judul';

        public function render_content()
        {
            echo '<hr><h3 style="margin:0;">' . esc_html($this->label) . '</h3>';
        }
    }

    $judul = function ($id, $label, $section, $priority = 10) use ($wp_customize) {
        $wp_customize->add_control(new Velocity_Hukum1_Judul_Control($wp_customize, $id, [
            'label'    => $label,
            'section'  => $section,
            'settings' => [],
            'priority' => $priority,
        ]));
    };

    $teks = function ($id, $label, $section, $args = []) use ($wp_customize) {
        $bawaan = velocity_hukum1_bawaan();
        $type = isset($args['type']) ? $args['type'] : 'text';
        $sanitasi = [
            'text'     => 'sanitize_text_field',
            'textarea' => 'wp_kses_post',
            'url'      => 'esc_url_raw',
        ];
        $wp_customize->add_setting($id, [
            'default'           => isset($bawaan[$id]) ? $bawaan[$id] : '',
            'sanitize_callback' => $sanitasi[$type],
        ]);
        $wp_customize->add_control($id, array_merge([
            'type'    => $type,
            'label'   => $label,
            'section' => $section,
        ], $args));
    };

    $gambar = function ($id, $label, $section, $keterangan) use ($wp_customize) {
        $wp_customize->add_setting($id, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, [
            'label'       => $label,
            'description' => $keterangan,
            'section'     => $section,
        ]));
    };

    // Daftar berulang (dulu repeater Kirki): slot tetap, minimal 6 (lebih bila data lama lebih banyak).
    $daftar = function ($mod, $label, $section) use ($wp_customize, $judul) {
        $baris = get_theme_mod($mod, []);
        $jumlah = max(VELOCITY_HUKUM1_SLOT_MIN, is_array($baris) ? count($baris) : 0);
        for ($i = 0; $i < $jumlah; $i++) {
            $judul("{$mod}_judul_$i", sprintf('%s %d', $label, $i + 1), $section, 20);
            $wp_customize->add_setting("{$mod}[$i][icon]", [
                'default'           => '',
                'sanitize_callback' => 'sanitize_html_class',
            ]);
            $wp_customize->add_control("{$mod}[$i][icon]", [
                'type'        => 'text',
                'label'       => __('Icon', 'justg'),
                'description' => __('Nama icon Bootstrap, contoh: hand-thumbs-up. Daftar icon:', 'justg') . ' icons.getbootstrap.com',
                'section'     => $section,
                'priority'    => 20,
                'input_attrs' => ['placeholder' => 'hand-thumbs-up'],
            ]);
            $wp_customize->add_setting("{$mod}[$i][nama]", [
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ]);
            $wp_customize->add_control("{$mod}[$i][nama]", [
                'type'     => 'text',
                'label'    => __('Nama', 'justg'),
                'section'  => $section,
                'priority' => 20,
            ]);
            $wp_customize->add_setting("{$mod}[$i][deskripsi]", [
                'default'           => '',
                'sanitize_callback' => 'sanitize_textarea_field',
            ]);
            $wp_customize->add_control("{$mod}[$i][deskripsi]", [
                'type'     => 'textarea',
                'label'    => __('Deskripsi', 'justg'),
                'section'  => $section,
                'priority' => 20,
            ]);
        }
    };

    $wp_customize->add_panel('panel_velocity', [
        'priority' => 10,
        'title'    => __('Velocity Theme', 'justg'),
    ]);

    // Warna & latar
    $wp_customize->add_section('section_colorvelocity', [
        'panel'    => 'panel_velocity',
        'title'    => __('Color & Background', 'justg'),
        'priority' => 10,
    ]);
    $warna = [
        'color_theme'  => [VELOCITY_HUKUM1_WARNA, __('Primary Theme Color', 'justg'), __('Warna utama (--bs-primary): latar seksi keunggulan, konsultasi, dan bar copyright.', 'justg')],
        'color_theme2' => [VELOCITY_HUKUM1_WARNA2, __('Secondary Theme Color', 'justg'), __('Warna kedua (--bs-secondary): header, menu, dan kartu layanan.', 'justg')],
    ];
    foreach ($warna as $id => [$bawaan, $label, $keterangan]) {
        $wp_customize->add_setting($id, [
            'default'           => $bawaan,
            'sanitize_callback' => 'sanitize_hex_color',
        ]);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, [
            'label'       => $label,
            'description' => $keterangan,
            'section'     => 'section_colorvelocity',
        ]));
    }

    $bawaan = velocity_hukum1_latar_bawaan();
    $wp_customize->add_setting('background_themewebsite[background-color]', [
        'default'           => $bawaan['background-color'],
        'sanitize_callback' => 'velocity_hukum1_sanitize_warna',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'background_themewebsite[background-color]', [
        'label'   => __('Website Background Color', 'justg'),
        'section' => 'section_colorvelocity',
    ]));
    $wp_customize->add_setting('background_themewebsite[background-image]', [
        'default'           => $bawaan['background-image'],
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'background_themewebsite[background-image]', [
        'label'   => __('Website Background Image', 'justg'),
        'section' => 'section_colorvelocity',
    ]));

    $pilihan = [
        'background-repeat'     => [__('Background Repeat', 'justg'), [
            'repeat'    => __('Repeat', 'justg'),
            'no-repeat' => __('No Repeat', 'justg'),
            'repeat-x'  => __('Repeat Horizontally', 'justg'),
            'repeat-y'  => __('Repeat Vertically', 'justg'),
        ]],
        'background-position'   => [__('Background Position', 'justg'), [
            'left top'      => __('Left Top', 'justg'),
            'left center'   => __('Left Center', 'justg'),
            'left bottom'   => __('Left Bottom', 'justg'),
            'center top'    => __('Center Top', 'justg'),
            'center center' => __('Center Center', 'justg'),
            'center bottom' => __('Center Bottom', 'justg'),
            'right top'     => __('Right Top', 'justg'),
            'right center'  => __('Right Center', 'justg'),
            'right bottom'  => __('Right Bottom', 'justg'),
        ]],
        'background-size'       => [__('Background Size', 'justg'), [
            'cover'   => __('Cover', 'justg'),
            'contain' => __('Contain', 'justg'),
            'auto'    => __('Auto', 'justg'),
        ]],
        'background-attachment' => [__('Background Attachment', 'justg'), [
            'scroll' => __('Scroll', 'justg'),
            'fixed'  => __('Fixed', 'justg'),
        ]],
    ];
    foreach ($pilihan as $kunci => [$label, $choices]) {
        $id = "background_themewebsite[$kunci]";
        $wp_customize->add_setting($id, [
            'default'           => $bawaan[$kunci],
            'sanitize_callback' => function ($nilai) use ($choices, $bawaan, $kunci) {
                return isset($choices[$nilai]) ? $nilai : $bawaan[$kunci];
            },
        ]);
        $wp_customize->add_control($id, [
            'type'    => 'select',
            'label'   => $label,
            'section' => 'section_colorvelocity',
            'choices' => $choices,
        ]);
    }

    // Top Home
    $wp_customize->add_section('top_home_section', [
        'panel'    => 'panel_velocity',
        'title'    => __('Top Home', 'justg'),
        'priority' => 20,
    ]);
    $gambar('hero_gambar', __('Gambar Hero', 'justg'), 'top_home_section', __('Ukuran rekomendasi: 800x1000px (portrait)', 'justg'));
    $teks('hero_slogan', __('Slogan', 'justg'), 'top_home_section');
    $teks('hero_judul', __('Judul Utama', 'justg'), 'top_home_section');
    $teks('hero_deskripsi', __('Deskripsi Singkat', 'justg'), 'top_home_section', [
        'type'        => 'textarea',
        'description' => __('Boleh berisi HTML (tautan, cetak tebal). Baris kosong = paragraf baru.', 'justg'),
    ]);

    // Keunggulan
    $wp_customize->add_section('keunggulan_section', [
        'panel'       => 'panel_velocity',
        'title'       => __('Halaman Depan - Keunggulan', 'justg'),
        'description' => __('Slot tanpa nama dan deskripsi tidak ditampilkan.', 'justg'),
        'priority'    => 50,
    ]);
    $teks('judul_keunggulan', __('Judul', 'justg'), 'keunggulan_section');
    $daftar('keunggulan_items', __('Keunggulan', 'justg'), 'keunggulan_section');

    // Layanan
    $wp_customize->add_section('layanan_section', [
        'panel'       => 'panel_velocity',
        'title'       => __('Halaman Depan - Layanan', 'justg'),
        'description' => __('Slot tanpa nama dan deskripsi tidak ditampilkan.', 'justg'),
        'priority'    => 50,
    ]);
    $teks('judul_layanan', __('Judul', 'justg'), 'layanan_section');
    $daftar('layanan_items', __('Layanan', 'justg'), 'layanan_section');
    $judul('info_tombol_layanan', __('Tombol Layanan', 'justg'), 'layanan_section', 30);
    $teks('teks_link_layanan', __('Teks Link', 'justg'), 'layanan_section', ['priority' => 30]);
    $teks('link_layanan', __('Link Layanan', 'justg'), 'layanan_section', [
        'type'        => 'url',
        'description' => __('Masukkan URL lengkap (contoh: https://contoh.com/layanan). Kosong = tombol disembunyikan.', 'justg'),
        'priority'    => 30,
    ]);

    // Konsultasi
    $wp_customize->add_section('konsultasi_section', [
        'panel'    => 'panel_velocity',
        'title'    => __('Halaman Depan - Konsultasi', 'justg'),
        'priority' => 60,
    ]);
    foreach ([1, 2] as $n) {
        $judul("info_konsultasi$n", sprintf(__('Konsultasi %d', 'justg'), $n), 'konsultasi_section');
        $gambar("gambar_konsultasi$n", __('Gambar', 'justg'), 'konsultasi_section', __('Ukuran rekomendasi: 600x400 px', 'justg'));
        $teks("judul_konsultasi$n", sprintf(__('Judul Konsultasi %d', 'justg'), $n), 'konsultasi_section');
        $teks("ket_konsultasi$n", __('Keterangan', 'justg'), 'konsultasi_section', [
            'type'        => 'textarea',
            'description' => __('Boleh berisi HTML, misalnya daftar &lt;ul&gt;&lt;li&gt;…&lt;/li&gt;&lt;/ul&gt;.', 'justg'),
        ]);
    }
    $judul('info_tombolwa', __('Tombol WhatsApp', 'justg'), 'konsultasi_section');
    $teks('wa_konsultasi', __('Nomor WhatsApp', 'justg'), 'konsultasi_section', [
        'description' => __('Contoh: 08123456789. Kosong = tombol disembunyikan.', 'justg'),
    ]);
    $teks('teks_tombol_konsultasi', __('Teks Tombol', 'justg'), 'konsultasi_section');
});

// Penyesuaian bagian bawaan WordPress & tema induk. Prioritas akhir supaya berjalan
// sesudah bagian itu terdaftar, termasuk panel Kirki tema induk lama bila Kirki masih aktif.
add_action('customize_register', function ($wp_customize) {
    // Identitas situs (logo header) masuk panel.
    $identitas = $wp_customize->get_section('title_tagline');
    if ($identitas) {
        $identitas->panel = 'panel_velocity';
        $identitas->priority = 5;
    }
    $wp_customize->remove_control('display_header_text');

    // Header memakai logo; Header Image tidak dipakai tema ini.
    $wp_customize->remove_section('header_image');
    $wp_customize->remove_section('header_section');

    // Digantikan Primary Theme Color & Website Background di atas.
    $wp_customize->remove_control('primary_color');
    $wp_customize->remove_section('velocity_section_background');
    foreach (['global_panel', 'panel_header', 'panel_footer', 'panel_antispam'] as $panel) {
        $wp_customize->remove_panel($panel);
    }
}, 1000);

/**
 * CSS dari pengaturan di atas. Dicetak di akhir <head> seperti Kirki dulu, supaya
 * menang atas CSS tema induk.
 */
add_action('wp_head', function () {
    $warna = sanitize_hex_color(get_theme_mod('color_theme', VELOCITY_HUKUM1_WARNA)) ?: VELOCITY_HUKUM1_WARNA;
    $warna2 = sanitize_hex_color(get_theme_mod('color_theme2', VELOCITY_HUKUM1_WARNA2)) ?: VELOCITY_HUKUM1_WARNA2;
    $css = ':root{--color-theme:' . $warna . ';--bs-primary:' . $warna . ';--bs-primary-rgb:' . velocity_hukum1_rgb($warna) . ';--primary:' . $warna . ';'
        . '--color-theme-secondary:' . $warna2 . ';--bs-secondary:' . $warna2 . ';--bs-secondary-rgb:' . velocity_hukum1_rgb($warna2) . ';}'
        . '.border-color-theme{--bs-border-color:' . $warna . ';}';

    $latar = get_theme_mod('background_themewebsite', []);
    $latar = array_merge(velocity_hukum1_latar_bawaan(), is_array($latar) ? $latar : []);
    $aturan = [];
    foreach ($latar as $prop => $nilai) {
        if (!array_key_exists($prop, velocity_hukum1_latar_bawaan())) {
            continue;
        }
        // Kirki bisa menyimpan id lampiran, bukan URL.
        if ($prop === 'background-image' && is_numeric($nilai)) {
            $nilai = wp_get_attachment_url((int) $nilai);
        }
        $nilai = trim((string) $nilai);
        if ($nilai === '') {
            continue;
        }
        if ($prop === 'background-color') {
            $nilai = velocity_hukum1_sanitize_warna($nilai);
        } elseif ($prop === 'background-image') {
            $nilai = 'url("' . esc_url($nilai) . '")';
        } else {
            $nilai = esc_attr($nilai);
        }
        if ($nilai !== '') {
            $aturan[] = $prop . ':' . $nilai;
        }
    }
    if ($aturan) {
        $css .= ':root[data-bs-theme=light] body,body{' . implode(';', $aturan) . ';}';
    }
    echo '<style id="velocity-hukum1-customizer">' . wp_strip_all_tags($css) . '</style>' . "\n";
}, 100);
