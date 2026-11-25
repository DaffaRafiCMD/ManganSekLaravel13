-- MANGANSEK FINAL 3 — Database MySQL / MariaDB untuk XAMPP
-- Import di phpMyAdmin: tab Import > pilih file ini > Go/Kirim
-- Tabel sesuai kode PHP ManganSek; tidak menghapus data lama bila diimpor ulang.
-- PENTING: proyek lama menggunakan storage/mangansek-store.php; backup data jika ada.
CREATE DATABASE IF NOT EXISTS `mangansek`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mangansek`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `telepon` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user','admin') NOT NULL DEFAULT 'user',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), UNIQUE KEY `uniq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tempat` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `kategori` ENUM('makanan','minuman','jajan') NOT NULL,
  `jenis` VARCHAR(30) NOT NULL,
  `jarak_km` DECIMAL(4,1) NOT NULL DEFAULT 0.0,
  `harga_min` INT UNSIGNED NOT NULL DEFAULT 0,
  `harga_max` INT UNSIGNED NOT NULL DEFAULT 0,
  `foto` VARCHAR(2048) NOT NULL DEFAULT '',
  `rating_dasar` DECIMAL(3,1) NOT NULL DEFAULT 0.0,
  `ulasan_dasar` INT UNSIGNED NOT NULL DEFAULT 0,
  `rekomendasi` TINYINT(1) NOT NULL DEFAULT 0,
  `dibuat_oleh` INT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`), KEY `idx_tempat_kategori` (`kategori`),
  CONSTRAINT `fk_tempat_creator` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`)
     ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `review` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tempat_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `rating` TINYINT UNSIGNED NOT NULL,
  `komentar` VARCHAR(500) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), KEY `idx_review_tempat` (`tempat_id`), KEY `idx_review_user` (`user_id`),
  CONSTRAINT `fk_review_tempat` FOREIGN KEY (`tempat_id`) REFERENCES `tempat` (`id`)
     ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
     ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `favorit` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `tempat_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`), UNIQUE KEY `uniq_favorit` (`user_id`,`tempat_id`),
  CONSTRAINT `fk_favorit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
     ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_favorit_tempat` FOREIGN KEY (`tempat_id`) REFERENCES `tempat` (`id`)
     ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `meal_hack` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `judul` VARCHAR(100) NOT NULL,
  `deskripsi` VARCHAR(255) NOT NULL,
  `hemat` INT UNSIGNED NOT NULL DEFAULT 0,
  `ikon` VARCHAR(30) NOT NULL DEFAULT 'lightbulb',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_meal_hack_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
     ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `promo` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(100) NOT NULL,
  `warna` VARCHAR(30) NOT NULL,
  `nama_tempat` VARCHAR(120) NOT NULL,
  `kategori` ENUM('makanan','minuman','jajan') NOT NULL,
  `deskripsi` VARCHAR(255) NOT NULL,
  `syarat` VARCHAR(255) NOT NULL,
  `berlaku_sampai` DATE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DATA DEMO AWAL (password admin tersimpan sebagai hash yang diverifikasi dengan password_verify).
-- Admin: admin@mangansek.test / ManganSek@2026!
-- Budi, Sinta, Dimas hanya akun contoh untuk review, tidak bisa dipakai login.

INSERT IGNORE INTO `users` (`id`, `nama`, `email`, `telepon`, `password`, `role`, `created_at`) VALUES
  (1, 'Budi', 'budi@example.com', NULL, '!', 'user', '2026-08-17 12:17:50'),
  (2, 'Sinta', 'sinta@example.com', NULL, '!', 'user', '2026-08-17 12:17:50'),
  (3, 'Dimas', 'dimas@example.com', NULL, '!', 'user', '2026-08-17 12:17:50'),
  (4, 'Admin ManganSek', 'admin@mangansek.test', NULL, '$2y$12$iUcvA2aE1/V.LjRcg0zH4OVyWXorYhwhP10a4D32wzFQ0xQPIG6/q', 'admin', '2026-11-15 12:17:50');

INSERT IGNORE INTO `tempat` (`id`, `nama`, `kategori`, `jenis`, `jarak_km`, `harga_min`, `harga_max`, `foto`, `rating_dasar`, `ulasan_dasar`, `rekomendasi`, `dibuat_oleh`) VALUES
  (1, 'Warung Bu Sari', 'makanan', 'Warung', 0.6, 8000, 15000, 'https://images.unsplash.com/photo-1707274860741-1320eda4ef52?auto=format&fit=crop&w=900&q=82', 4.5, 120, 1, NULL),
  (2, 'Mie Ayam Pak Slamet', 'makanan', 'Mie', 1.2, 7000, 12000, 'https://images.unsplash.com/photo-1747317277795-0d601795682c?auto=format&fit=crop&w=900&q=82', 4.3, 98, 1, NULL),
  (3, 'Warteg Sederhana', 'makanan', 'Warteg', 1.5, 6000, 14000, 'https://images.unsplash.com/photo-1707274860723-52233290a977?auto=format&fit=crop&w=900&q=82', 4.2, 76, 1, NULL),
  (4, 'Ayam Geprek Mas Dika', 'makanan', 'Ayam', 0.9, 10000, 16000, 'https://images.unsplash.com/photo-1744968048879-2c79641429e4?auto=format&fit=crop&w=900&q=82', 4.6, 143, 0, NULL),
  (5, 'Kopi Kenangan (Cab. Kampus)', 'minuman', 'Minuman', 1.8, 8000, 18000, 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=900&q=82', 4.4, 110, 1, NULL),
  (6, 'Es Teh Poci', 'minuman', 'Teh', 0.5, 3000, 6000, 'https://images.unsplash.com/photo-1596343540266-130b3dbb1158?auto=format&fit=crop&w=900&q=82', 4.5, 210, 0, NULL),
  (7, 'Jus Buah Bu Wati', 'minuman', 'Jus', 1, 7000, 12000, 'https://images.unsplash.com/photo-1577680716097-9a565ddc2007?auto=format&fit=crop&w=900&q=82', 4.3, 74, 0, NULL),
  (8, 'Susu Kedelai Pak Joko', 'minuman', 'Susu', 0.8, 4000, 7000, 'https://thumb.wikimedia.org/wikipedia/commons/thumb/5/5f/Soy_milk.jpg/500px-Soy_milk.jpg', 4.2, 52, 0, NULL),
  (9, 'Cilok Pak Eko', 'jajan', 'Cilok', 0.3, 2000, 8000, 'https://thumb.wikimedia.org/wikipedia/commons/thumb/2/27/Cilok.jpg/500px-Cilok.jpg', 4.6, 188, 0, NULL),
  (10, 'Cireng Isi Mbak Yuni', 'jajan', 'Gorengan', 0.7, 3000, 10000, 'https://thumb.wikimedia.org/wikipedia/commons/thumb/4/45/Cireng_isi.jpg/960px-Cireng_isi.jpg', 4.4, 95, 0, NULL),
  (11, 'Pisang Goreng Keju', 'jajan', 'Manis', 1, 5000, 12000, 'https://images.unsplash.com/photo-1576867917480-152bca50166e?auto=format&fit=crop&w=900&q=82', 4.5, 120, 0, NULL),
  (12, 'Seblak Teh Neng', 'jajan', 'Pedas', 1.3, 8000, 15000, 'https://images.unsplash.com/photo-1645696288939-e59ed5e3cfa2?auto=format&fit=crop&w=900&q=82', 4.3, 88, 0, NULL);

INSERT IGNORE INTO `review` (`id`, `tempat_id`, `user_id`, `rating`, `komentar`, `created_at`) VALUES
  (1, 1, 3, 3, 'Rasa oke, tempat agak sempit kalau lagi ramai.', '2026-10-16 12:17:50'),
  (2, 1, 2, 5, 'Sambalnya juara, bakal balik lagi bareng teman kos.', '2026-11-01 12:17:50'),
  (3, 1, 1, 4, 'Enak, cuma kadang antriannya panjang pas jam makan siang.', '2026-11-08 12:17:50');

INSERT IGNORE INTO `meal_hack` (`id`, `user_id`, `judul`, `deskripsi`, `hemat`, `ikon`) VALUES
  (1, NULL, 'Nasi kosong + lauk warteg', 'Rakit sendiri lebih murah daripada paket', 4000, 'lightbulb'),
  (2, NULL, 'Bawa tumbler dari kos', 'Banyak kedai kasih diskon kalau bawa tumbler', 2000, 'lightbulb'),
  (3, NULL, 'Mie instan + sawi + telur', 'Tambah sayur biar lebih bergizi', 5000, 'lightbulb'),
  (4, NULL, 'Nasi telur dadar + kecap', 'Cuma Rp 6.000, kenyang sampai sore', 8000, 'lightbulb');

INSERT IGNORE INTO `promo` (`id`, `judul`, `warna`, `nama_tempat`, `kategori`, `deskripsi`, `syarat`, `berlaku_sampai`) VALUES
  (1, 'Diskon 20%', 'yellow', 'Warung Bu Sari', 'makanan', 'Diskon 20% paket nasi ayam khusus mahasiswa', 'Tunjukkan KTM saat memesan.', '2026-10-31'),
  (2, 'Beli 1 Gratis 1', 'pink', 'Kopi Kenangan', 'minuman', 'Berlaku setiap Jumat dengan menunjukkan KTM', 'Satu promo per KTM per hari.', '2026-11-30'),
  (3, 'Potongan Rp 2.000', 'green', 'Mie Ayam Pak Slamet', 'makanan', 'Minimal pembelian Rp 10.000 per transaksi', 'Tidak berlaku untuk pesanan antar.', '2026-10-25'),
  (4, 'Gratis Es Teh', 'blue', 'Warteg Sederhana', 'makanan', 'Untuk setiap pembelian paket hemat', 'Satu es teh per paket hemat.', '2026-11-15'),
  (5, 'Diskon 15%', 'purple', 'Cilok Pak Eko', 'jajan', 'Pembelian minimal 10 tusuk cilok', 'Berlaku untuk makan di tempat dan bawa pulang.', '2026-10-20'),
  (6, 'Cashback 10%', 'peach', 'Soto Ayam Bu Tin', 'makanan', 'Bayar pakai e-wallet, maksimal Rp 5.000', 'Cashback masuk dalam 1x24 jam.', '2026-12-31');

-- Tes setelah impor:
-- SELECT COUNT(*) AS jumlah_menu FROM tempat;
-- SELECT id,nama,kategori,harga_min,harga_max FROM tempat;
-- SELECT id,nama,email,role FROM users;
