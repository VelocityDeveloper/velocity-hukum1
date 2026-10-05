# Alur Isi Data Child Theme Hukum1

## Plugin

- Wajib aktif: **Velocity Addons**.
- Plugin **Kirki** (sejak 1.1.0) **tidak diperlukan**; semua pengaturan ada di Customizer bawaan WordPress.

## Customize

1. Set halaman **Beranda** mengambil template **"Home Template"**, lalu jadikan halaman depan (Settings › Reading › A static page).
   - Isi beranda (hero, keunggulan, layanan, konsultasi) diambil dari pengaturan Customize di bawah, bukan dari isi halaman.
2. Isi **Velocity Theme**:
   1. **Site Identity**: **Logo** klien, site title, tagline, site icon.
      - Logo tampil di header kiri di atas latar **Secondary Theme Color**; ukuran demo **283 x 70 px** (rasio melebar ±4:1).
      - Tema ini tidak memakai Header Image.
   2. **Color & Background**:
      - **Primary Theme Color**: latar seksi keunggulan, seksi konsultasi, dan bar copyright (demo **#583207**).
      - **Secondary Theme Color**: latar header, menu HP, dan kartu layanan (demo **#ca9e68**).
      - Sesuaikan kedua warna dengan warna logo klien; teks di atas kedua warna ini berwarna putih, jadi pilih warna yang cukup gelap/kontras.
      - **Website Background**: biarkan putih (**#ffffff**).
   3. **Top Home** (hero beranda):
      - **Gambar Hero** ukuran **800 x 1000 px (portrait)**, tampil di kolom kiri setinggi layar. Apabila tidak ada foto dari client, gunakan foto bertema hukum (palu hakim, timbangan, kantor advokat).
      - **Slogan**, **Judul Utama** (nama firma/kantor hukum), dan **Deskripsi Singkat** (1–2 paragraf + baris "Hubungi kami:" berisi telepon dan email klien; boleh HTML tautan `tel:` / `mailto:`).
   4. **Halaman Depan - Keunggulan**: judul (bawaan "Mengapa Memilih Kami?") dan **4 keunggulan** (tampil 2 kolom).
      - Tiap keunggulan: **Icon** (nama icon Bootstrap tanpa awalan `bi-`, mis. `clock`, `person-check`, `phone`, `currency-exchange`), **Nama**, **Deskripsi** singkat (1–2 kalimat).
      - Slot tanpa nama dan deskripsi tidak ditampilkan.
   5. **Halaman Depan - Layanan**: judul (bawaan "Layanan Kami") dan **3 layanan** (tampil 3 kolom; 6 layanan = 2 baris penuh).
      - Tiap layanan: **Icon** (mis. `chat-dots`, `file-earmark-text`, `shield-check`), **Nama**, **Deskripsi**.
      - **Tombol Layanan**: Teks Link "Lihat Semua Layanan" dan **Link Layanan** = URL halaman Layanan Kami. Kosong = tombol tidak tampil.
   6. **Halaman Depan - Konsultasi**: dua kartu berdampingan.
      - **Konsultasi 1** (demo "Konsultasi Online") dan **Konsultasi 2** (demo "Konsultasi Tatap Muka"): **Gambar 600 x 400 px**, judul, dan **Keterangan** berupa daftar poin (HTML `<ul><li>…</li></ul>`, 3–4 poin).
      - **Tombol WhatsApp**: nomor WA klien (format 08xxx) dan teks tombol (bawaan "Konsultasi Sekarang"). Kosong = tombol tidak tampil.
      - Apabila tidak ada data dari client, ambil dari form isian website.
3. **Menus**: buat menu di lokasi **Primary Menu**: Beranda, Tentang Kami, Tim Kami, Layanan Kami, Artikel (arsip kategori), Kontak Kami.

## Halaman

- **Tentang Kami**: profil firma (paragraf + subjudul), boleh ditambah daftar visi/misi atau bidang keahlian.
- **Tim Kami**: blok **Columns 3 kolom**, tiap kolom berisi foto advokat (**rasio 2:3 portrait**), nama + gelar (mis. "Kendra Santoso, S.H."), dan jabatan (Managing Partner, Senior Associate, Associate).
  - Apabila tidak ada data tim dari client, halaman ini boleh dihapus dari menu.
- **Layanan Kami**: kalimat pembuka + daftar layanan lengkap (list), sesuai layanan di form isian.
- **Kontak Kami**: nama kantor, alamat, telepon, WhatsApp, email, dan peta Google Maps (blok **Custom HTML** berisi iframe).

## Artikel

- Kategori **Artikel**, minimal **3 artikel** bertema hukum dengan gambar unggulan; dipakai widget sidebar dan menu Artikel.

## Widgets

- Pada **Main Sidebar**:
  1. **Recent Posts** berjudul "Artikel Terbaru", jumlah **5**.
  2. **Custom HTML** berjudul "Peta Lokasi" berisi iframe Google Maps kantor klien (width 100%, height 350).
- Pada **Footer Widget Area 1–3** (widget **Text**):
  1. **Tentang Kami**: 2–3 kalimat profil singkat firma.
  2. **Layanan Kami**: daftar layanan (list).
  3. **Kontak Kami**: alamat (tautan Google Maps), telepon, WhatsApp, email.

## Gallery

- Demo tidak memakai halaman Gallery. Apabila client meminta galeri, aktifkan **Gallery Post Type** di Velocity Addons dan gunakan shortcode **VD Gallery** (`[vdgallery id="..."]`).

## Logo Header

- Logo dipasang lewat **Site Identity › Logo** (bukan Header Image), lebar tampil mengikuti kolom header (±25% lebar container).
- Header berlatar **Secondary Theme Color**; apabila warna logo tidak kontras dengan warna itu, berikan **background putih** di belakang logo atau sesuaikan Secondary Theme Color.
