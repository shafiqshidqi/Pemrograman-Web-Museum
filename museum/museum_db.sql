-- Buat database
CREATE DATABASE IF NOT EXISTS museum_db;
USE museum_db;

-- Tabel admin
CREATE TABLE admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel koleksi
CREATE TABLE koleksi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(200) NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel event
CREATE TABLE event (
    id INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(200) NOT NULL,
    poster VARCHAR(255) NOT NULL,
    tanggal DATE NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin default (username: admin, password: admin123)
INSERT INTO admin (username, password_hash) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert data contoh koleksi
INSERT INTO koleksi (nama, gambar, deskripsi) VALUES 
('Keris Nusantara', 'keris.jpg', 'Koleksi keris antik dari berbagai daerah di Nusantara, abad ke-17 hingga ke-19.'),
('Prasasti Kuno', 'prasasti.jpg', 'Prasasti berbahasa Jawa Kuno yang menceritakan sejarah kerajaan masa lampau.'),
('Wayang Kulit Jawa', 'wayang.jpg', 'Wayang kulit klasik buatan dalang legendaris dengan detail ukiran yang indah.'),
('Batik Keraton', 'batik.jpg', 'Batik klasik dengan motif larangan yang hanya digunakan oleh keluarga keraton.'),
('Gamelan Sekaten', 'gamelan.jpg', 'Seperangkat gamelan kuno yang digunakan dalam upacara Sekaten di Yogyakarta.');

-- Insert data contoh event
INSERT INTO event (judul, poster, tanggal, deskripsi) VALUES 
('Pameran Seni Rupa Kontemporer', 'event1.jpg', '2025-12-15', 'Pameran karya seniman lokal yang menggabungkan seni tradisional dengan modern.'),
('Festival Wayang Nusantara', 'event2.jpg', '2025-12-20', 'Pertunjukan wayang dari berbagai daerah di Indonesia selama 3 hari.'),
('Workshop Batik Tulis', 'event3.jpg', '2025-12-25', 'Belajar teknik membatik tulis langsung dari pengrajin batik berpengalaman.');