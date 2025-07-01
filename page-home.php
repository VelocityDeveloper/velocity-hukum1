<?php

/**
 * Template Name: Home Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package justg
 */

get_header();

$hero_image      = velocitytheme_option('hero_gambar');
$hero_slogan     = velocitytheme_option('hero_slogan', get_bloginfo('description')); // Fallback to tagline
$hero_title      = velocitytheme_option('hero_judul', get_bloginfo('name')); // Fallback to site title
$hero_desc       = velocitytheme_option('hero_deskripsi');

$judul_keunggulan = velocitytheme_option('judul_keunggulan');
$keunggulan = velocitytheme_option('keunggulan_items');
$home_judul_galeri = velocitytheme_option('home_judul_galeri');
$home_galeri = velocitytheme_option('home_galeri');

$judul_layanan    = velocitytheme_option('judul_layanan');
$layanan_items    = velocitytheme_option('layanan_items', []);
$link_layanan     = velocitytheme_option('link_layanan');
$teks_link_layanan= velocitytheme_option('teks_link_layanan');


$judul_konsultasi1 = velocitytheme_option('judul_konsultasi1', 'Konsultasi Online');
$gambar_konsultasi1 = velocitytheme_option('gambar_konsultasi1');
$ket_konsultasi1   = velocitytheme_option('ket_konsultasi1');

$judul_konsultasi2 = velocitytheme_option('judul_konsultasi2', 'Konsultasi Tatap Muka');
$gambar_konsultasi2 = velocitytheme_option('gambar_konsultasi2');
$ket_konsultasi2   = velocitytheme_option('ket_konsultasi2');

$wa_konsultasi     = velocitytheme_option('wa_konsultasi');
$teks_tombol_konsultasi = velocitytheme_option('teks_tombol_konsultasi', 'Konsultasi Sekarang');
?>

<div class="wrapper" id="page-wrapper">

<section class="velocity-top-home bg-light">
    <div class="container-fluid">
        <div class="row align-items-stretch">
            <!-- Hero Image Column (40%) -->
            <div class="col-lg-5 col-xl-4 p-0 velocity-hero-image">
                <?php if ($hero_image) : ?>
                    <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr($hero_title); ?>" class="img-fluid h-100 w-100 object-fit-cover">
                <?php else : ?>
                    <div class="velocity-hero-placeholder bg-light d-flex align-items-center justify-content-center">
                        <span class="text-muted"><?php esc_html_e('Hero Image Placeholder', 'velocity'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Hero Content Column (60%) -->
            <div class="col-lg-7 col-xl-8 velocity-hero-content text-center">
                <div class="velocity-hero-content-inner">
                    <?php if ($hero_slogan) : ?>
                        <p class="color-theme fw-bold fs-4 text-uppercase"><?php echo esc_html($hero_slogan); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($hero_title) : ?>
                        <h1 class="velocity-top-title fw-bold text-uppercase"><?php echo esc_html($hero_title); ?></h1>
                    <?php endif; ?>
                    
                    <?php if ($hero_desc) : ?>
                        <div class="velocity-description velocity-content mt-3">
                            <?php echo wpautop(wp_kses_post($hero_desc)); ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>


<?php if (!empty($keunggulan)) : ?>
<section class="bg-theme text-white velocity-keunggulan">
    <div class="container py-5">
        <div class="row py-5 mt-3 px-md-5">
            <h2 class="col-12 fs-2 fw-bold text-center text-white mb-4 pb-md-3"><?php echo esc_html($judul_keunggulan); ?></h2>
            
            <?php foreach ($keunggulan as $item) : ?>
                <div class="col-md-6 mb-4"> <!-- Ubah dari col-md-3 ke col-md-6 untuk 2 kolom -->
                    <div class="h-100">
                        <div class="row text-md-start text-center mb-md-3"> <!-- Baris dalam card -->
                            <!-- Kolom Kiri (Logo) -->
                            <div class="col-md-3 pe-md-3 text-md-end"> 
                                <?php if (!empty($item['icon'])) : ?>
                                    <i class="bi bi-<?php echo esc_attr($item['icon']); ?>"></i>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Kolom Kanan (Konten) -->
                            <div class="col-md-9">
                                <?php if (!empty($item['nama'])) : ?>
                                    <h3 class="h4 fw-bold mb-2 text-white"><?php echo esc_html($item['nama']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($item['deskripsi'])) : ?>
                                    <p class="text-white mb-0"><?php echo esc_html($item['deskripsi']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>



<section class="velocity-layanan py-5">
  <div class="container py-5 mt-3">
    
    <!-- Judul -->
    <h2 class="fs-2 fw-bold text-center text-dark mb-4 pb-md-3"><?php echo esc_html($judul_layanan); ?></h2>

    <!-- Grid Kolom -->
    <div class="row g-4">

      <?php if (!empty($layanan_items)) : ?>
        <?php foreach ($layanan_items as $item) : 
          $icon    = isset($item['icon']) ? esc_attr($item['icon']) : 'info-circle';
          $nama    = isset($item['nama']) ? esc_html($item['nama']) : '';
          $deskripsi = isset($item['deskripsi']) ? esc_html($item['deskripsi']) : '';
        ?>

          <div class="col-md-4">
            <div class="bg-theme-secondary h-100 rounded text-center px-3 py-4">
              <!-- Icon -->
              <div class="mb-3">
                <i class="bi bi-<?php echo $icon; ?>"></i>
              </div>
              <!-- Konten -->
                <h5 class="text-white fs-4"><?php echo $nama; ?></h5>
                <p><?php echo $deskripsi; ?></p>
            </div>
          </div>

        <?php endforeach; ?>
      <?php else : ?>
        <p class="text-center">Belum ada layanan yang ditambahkan.</p>
      <?php endif; ?>

    </div>

    <!-- Tombol -->
    <?php if (!empty($link_layanan)) : ?>
      <div class="text-center pt-4 mt-3">
        <a href="<?php echo esc_url($link_layanan); ?>" class="btn btn-outline-primary btn-lg">
          <?php echo esc_html($teks_link_layanan); ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>



<!-- SECTION: Konsultasi -->
<section class="velocity-konsultasi py-5 bg-theme">
  <div class="container py-5 px-md-5">
    <div class="row align-items-center px-md-5 mx-md-4">

      <!-- Kolom 1: Konsultasi 1 -->
      <div class="col-md-6 mb-4 mb-md-0">
      <div class="bg-white p-3 h-100">
        <?php if (!empty($gambar_konsultasi1)) : ?>
          <img src="<?php echo esc_url($gambar_konsultasi1); ?>" alt="<?php echo esc_attr($judul_konsultasi1); ?>" class="img-fluid rounded shadow-sm mb-3" style="max-height: 300px; object-fit: cover; width: 100%;">
        <?php endif; ?>
        <h4 class="text-center fs-4 fw-bold mb-3"><?php echo esc_html($judul_konsultasi1); ?></h4>
        <div class="text-muted velocity-content">
          <?php echo wp_kses_post($ket_konsultasi1); ?>
        </div>
      </div>
      </div>

      <!-- Kolom 2: Konsultasi 2 -->
      <div class="col-md-6">
      <div class="bg-white p-3 h-100">
        <?php if (!empty($gambar_konsultasi2)) : ?>
          <img src="<?php echo esc_url($gambar_konsultasi2); ?>" alt="<?php echo esc_attr($judul_konsultasi2); ?>" class="img-fluid rounded shadow-sm mb-3" style="max-height: 300px; object-fit: cover; width: 100%;">
        <?php endif; ?>
        <h4 class="text-center fs-4 fw-bold mb-3"><?php echo esc_html($judul_konsultasi2); ?></h4>
        <div class="text-muted velocity-content">
          <?php echo wp_kses_post($ket_konsultasi2); ?>
        </div>
      </div>
      </div>

    </div>

    <!-- Tombol WhatsApp -->
    <?php if (!empty($wa_konsultasi)) : ?>
      <div class="text-center mt-4 pt-3">
        <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $wa_konsultasi); ?>" target="_blank" class="btn btn-success btn-lg">
          <i class="bi bi-whatsapp me-2"></i> <?php echo esc_html($teks_tombol_konsultasi); ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>




</div><!-- #page-wrapper -->

<?php
get_footer();
