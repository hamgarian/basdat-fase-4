-- =============================================================================
-- PROYEK FASE 3: IMPLEMENTASI FISIK
-- Database: Manajemen Data Safety, Security & Quality Penerbangan
-- DBMS: PostgreSQL
--
-- Skrip ini berisi:
-- 1. Perintah DDL (Data Definition Language) untuk membuat semua tabel.
-- 2. Perintah DML (Data Manipulation Language) untuk memasukkan data contoh.
--
-- CATATAN: Script ini hanya akan membuat tabel jika belum ada.
-- Jika tabel sudah ada, script akan di-skip untuk mencegah data loss.
-- =============================================================================

-- Check if tables already exist at the beginning
-- If tables exist, this script will be skipped by the entrypoint script
-- This comment serves as documentation that the check happens in docker-entrypoint.sh

-- =============================================================================
-- BAGIAN 1: DDL (CREATE TABLE)
-- Pembuatan tabel diurutkan berdasarkan dependensi foreign key.
-- =============================================================================

-- Tabel 1: USER (Entitas dasar untuk login)
-- Tidak memiliki foreign key
CREATE TABLE "user" (
    id_user SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    "password" VARCHAR(255) NOT NULL
);

-- Tabel 2: CLIENT (Entitas pemilik pesawat)
-- Tidak memiliki foreign key
CREATE TABLE client (
    id_client SERIAL PRIMARY KEY,
    nama_perusahaan VARCHAR(100) NOT NULL,
    contact_person VARCHAR(100),
    nomor_telepon VARCHAR(20),
    alamat TEXT
);

-- Tabel 3: KARYAWAN (Detail pegawai, terhubung ke user)
-- Bergantung pada tabel "user"
CREATE TABLE karyawan (
    id_karyawan SERIAL PRIMARY KEY,
    id_user INT NOT NULL UNIQUE,
    nama_karyawan VARCHAR(100) NOT NULL,
    nik VARCHAR(20) NOT NULL UNIQUE,
    tanggal_lahir DATE,
    alamat TEXT,
    nomor_telepon VARCHAR(20),
    FOREIGN KEY (id_user) REFERENCES "user"(id_user)
);

-- Tabel 4: PESAWAT (Entitas utama aset penerbangan)
-- Bergantung pada tabel "client"
CREATE TABLE pesawat (
    id_pesawat SERIAL PRIMARY KEY,
    id_client INT NOT NULL,
    registrasi VARCHAR(10) NOT NULL UNIQUE,
    merk_model VARCHAR(50) NOT NULL,
    tahun_pembuatan INT CHECK (tahun_pembuatan <= EXTRACT(YEAR FROM CURRENT_DATE)),
    jam_terbang INT CHECK (jam_terbang >= 0),
    status VARCHAR(20),
    FOREIGN KEY (id_client) REFERENCES client(id_client)
);

-- Tabel 5 & 6: Sub-entitas dari PESAWAT (Generalisasi/Spesialisasi)
-- Bergantung pada tabel "pesawat"
CREATE TABLE helicopter (
    id_pesawat INT PRIMARY KEY,
    tipe_mesin VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_pesawat) REFERENCES pesawat(id_pesawat) ON DELETE CASCADE
);

CREATE TABLE private_jet (
    id_pesawat INT PRIMARY KEY,
    kapasitas_penumpang INT,
    jangkauan_terbang INT,
    FOREIGN KEY (id_pesawat) REFERENCES pesawat(id_pesawat) ON DELETE CASCADE
);

-- Tabel 7: PENERBANGAN (Jadwal atau riwayat penerbangan)
-- Bergantung pada tabel "pesawat"
CREATE TABLE penerbangan (
    id_penerbangan SERIAL PRIMARY KEY,
    id_pesawat INT NOT NULL,
    tanggal_penerbangan DATE NOT NULL,
    jenis_penerbangan VARCHAR(30),
    status_penerbangan VARCHAR(20),
    catatan TEXT,
    FOREIGN KEY (id_pesawat) REFERENCES pesawat(id_pesawat)
);

-- Tabel 8: PILOT (Data spesifik untuk pilot, yang merupakan karyawan)
-- Bergantung pada tabel "karyawan"
CREATE TABLE pilot (
    id_pilot SERIAL PRIMARY KEY,
    id_karyawan INT NOT NULL UNIQUE,
    lisensi_pilot VARCHAR(30) NOT NULL,
    jam_terbang_total INT CHECK (jam_terbang_total >= 0),
    rating_pesawat VARCHAR(100),
    status VARCHAR(20),
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id_karyawan)
);

-- Tabel 9: FLIGHT_MOVEMENT (Detail pergerakan penerbangan oleh pilot)
-- Bergantung pada tabel "penerbangan" dan "pilot"
CREATE TABLE flight_movement (
    id_flight_movement SERIAL PRIMARY KEY,
    id_penerbangan INT NOT NULL,
    id_pilot INT NOT NULL,
    tanggal_penerbangan DATE,
    rute VARCHAR(100),
    jam_terbang INT,
    FOREIGN KEY (id_penerbangan) REFERENCES penerbangan(id_penerbangan),
    FOREIGN KEY (id_pilot) REFERENCES pilot(id_pilot)
);

-- Tabel 10: INCIDENT (Laporan insiden terkait penerbangan)
-- Bergantung pada tabel "penerbangan"
CREATE TABLE incident (
    id_incident SERIAL PRIMARY KEY,
    id_penerbangan INT NOT NULL,
    kategori_insiden VARCHAR(50),
    lokasi_insiden VARCHAR(100),
    status VARCHAR(30),
    FOREIGN KEY (id_penerbangan) REFERENCES penerbangan(id_penerbangan)
);

-- Tabel 11: HAZARD_REPORT (Laporan potensi bahaya dari karyawan)
-- Bergantung pada tabel "karyawan"
CREATE TABLE hazard_report (
    id_hazard SERIAL PRIMARY KEY,
    id_karyawan INT NOT NULL,
    nama_pelapor VARCHAR(100),
    tanggal_laporan DATE NOT NULL,
    kategori VARCHAR(50),
    deskripsi TEXT,
    status VARCHAR(30),
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id_karyawan)
);

-- Tabel 12: INVESTIGATION (Tindak lanjut dari laporan hazard)
-- Bergantung pada tabel "hazard_report"
CREATE TABLE investigation (
    id_investigasi SERIAL PRIMARY KEY,
    id_hazard INT NOT NULL,
    tanggal_mulai DATE,
    tanggal_selesai DATE,
    teknologi TEXT,
    hasil_wawancara TEXT,
    FOREIGN KEY (id_hazard) REFERENCES hazard_report(id_hazard)
);

-- Tabel 13: AUDIT (Kegiatan audit internal/eksternal)
-- Bergantung pada tabel "karyawan"
CREATE TABLE audit (
    id_audit SERIAL PRIMARY KEY,
    id_karyawan INT NOT NULL,
    nomor_audit VARCHAR(50) NOT NULL,
    judul VARCHAR(100),
    kategori VARCHAR(50),
    tanggal_pelaksanaan DATE,
    keterangan TEXT,
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id_karyawan)
);

-- Tabel 14: TEMUAN (Hasil spesifik dari sebuah audit)
-- Bergantung pada tabel "audit"
CREATE TABLE temuan (
    id_temuan SERIAL PRIMARY KEY,
    id_audit INT NOT NULL,
    deskripsi_temuan TEXT,
    rekomendasi TEXT,
    status_tindak_lanjut VARCHAR(30),
    FOREIGN KEY (id_audit) REFERENCES audit(id_audit)
);

-- Tabel 15: LIBRARY_MANUAL (Dokumen dan manual operasional)
-- Bergantung pada tabel "karyawan"
CREATE TABLE library_manual (
    id_manual SERIAL PRIMARY KEY,
    id_karyawan INT NOT NULL, -- Penanggung jawab / penulis
    judul_manual VARCHAR(150) NOT NULL,
    tanggal_terbit DATE,
    departemen_pemilik VARCHAR(50),
    status VARCHAR(20),
    FOREIGN KEY (id_karyawan) REFERENCES karyawan(id_karyawan)
);

-- =============================================================================
-- BAGIAN 2: DML (INSERT DATA CONTOH)
-- Memasukkan 5 record contoh untuk setiap tabel
-- =============================================================================

INSERT INTO "user" (username, password) VALUES
('budi.s', 'pass123'), ('siti.a', 'pass123'), ('agus.w', 'pass123'), ('dina.r', 'pass123'), ('eko.p', 'pass123');

INSERT INTO client (nama_perusahaan, contact_person, nomor_telepon, alamat) VALUES
('PT. Maju Jaya', 'Andi', '021-555-1111', 'Gedung A, Jakarta'),
('CV. Sumber Rejeki', 'Rina', '022-555-2222', 'Kawasan Industri, Bandung'),
('Global Mining Corp', 'Steven', '031-555-3333', 'Plaza B, Surabaya'),
('Paradise Resort', 'Maria', '0361-555-4444', 'Jl. Pantai Kuta, Bali'),
('Oil & Gas Solutions', 'Hendra', '0542-555-5555', 'Komp. Migas, Balikpapan');

INSERT INTO karyawan (id_user, nama_karyawan, nik, tanggal_lahir, alamat, nomor_telepon) VALUES
(1, 'Budi Santoso', '3201011010900001', '1990-10-10', 'Jl. Merdeka No. 1, Jakarta', '081234567890'),
(2, 'Siti Aminah', '3201012011920002', '1992-11-20', 'Jl. Pahlawan No. 2, Bandung', '081234567891'),
(3, 'Agus Wijaya', '3201011505880003', '1988-05-15', 'Jl. Sudirman No. 3, Surabaya', '081234567892'),
(4, 'Dina Rahmawati', '3201012503950004', '1995-03-25', 'Jl. Gajah Mada No. 4, Yogyakarta', '081234567893'),
(5, 'Eko Prasetyo', '3201013008850005', '1985-08-30', 'Jl. Diponegoro No. 5, Semarang', '081234567894');

INSERT INTO pesawat (id_client, registrasi, merk_model, tahun_pembuatan, jam_terbang, status) VALUES
(1, 'PK-MJA', 'Boeing 737', 2018, 5000, 'Aktif'),
(4, 'PK-PRD', 'Gulfstream G650', 2021, 1500, 'Aktif'),
(3, 'PK-GMC', 'Bell 429', 2019, 3000, 'Perawatan'),
(5, 'PK-OGS', 'Sikorsky S-92', 2017, 6000, 'Grounded'),
(2, 'PK-SRA', 'ATR 72', 2020, 2500, 'Aktif');

INSERT INTO helicopter (id_pesawat, tipe_mesin) VALUES
(3, 'Turboshaft Twin-Engine'),
(4, 'Turboshaft Twin-Engine');

INSERT INTO private_jet (id_pesawat, kapasitas_penumpang, jangkauan_terbang) VALUES
(2, 12, 7500);

INSERT INTO penerbangan (id_pesawat, tanggal_penerbangan, jenis_penerbangan, status_penerbangan, catatan) VALUES
(1, '2023-10-01', 'Charter', 'Completed', 'Penerbangan VIP'),
(2, '2023-10-02', 'Private', 'Completed', 'Keluarga Bpk. Steven'),
(5, '2023-10-03', 'Kargo', 'Scheduled', 'Logistik pertambangan'),
(3, '2023-10-04', 'Medevac', 'Cancelled', 'Kondisi cuaca buruk'),
(1, '2023-10-05', 'Charter', 'Scheduled', 'Rombongan direksi');

INSERT INTO pilot (id_karyawan, lisensi_pilot, jam_terbang_total, rating_pesawat, status) VALUES
(1, 'ATPL-123456', 5500, 'B737, G650', 'Aktif'),
(2, 'CPL-H-456789', 3200, 'Bell 429', 'Aktif'),
(3, 'ATPL-789012', 12000, 'B737, ATR 72', 'Aktif'),
(5, 'CPL-H-987654', 6500, 'Sikorsky S-92', 'Cuti');

INSERT INTO flight_movement (id_penerbangan, id_pilot, tanggal_penerbangan, rute, jam_terbang) VALUES
(1, 1, '2023-10-01', 'CGK-DPS', 2),
(2, 1, '2023-10-02', 'HLP-SUB', 1),
(5, 3, '2023-10-05', 'CGK-SIN', 2);

INSERT INTO incident (id_penerbangan, kategori_insiden, lokasi_insiden, status) VALUES
(1, 'Minor Turbulence', 'Di atas Laut Jawa', 'Closed'),
(2, 'Bird Strike', 'Saat pendaratan di SUB', 'Investigation'),
(4, 'Engine Warning Light', 'Sebelum takeoff HLP', 'Closed');

INSERT INTO hazard_report (id_karyawan, nama_pelapor, tanggal_laporan, kategori, deskripsi, status) VALUES
(1, 'Budi Santoso', '2023-09-15', 'FOD', 'Ditemukan baut di apron C3', 'Investigated'),
(4, 'Dina Rahmawati', '2023-09-20', 'Ground Handling', 'Prosedur baggage loading tidak sesuai manual', 'Open'),
(5, 'Eko Prasetyo', '2023-09-21', 'Maintenance', 'Torque wrench belum dikalibrasi', 'In Progress'),
(1, 'Budi Santoso', '2023-09-22', 'Wildlife', 'Terlihat banyak burung di sekitar runway 25', 'Mitigated'),
(2, 'Siti Aminah', '2023-09-25', 'Documentation', 'Logbook penerbangan tidak lengkap', 'Open');

INSERT INTO investigation (id_hazard, tanggal_mulai, tanggal_selesai, teknologi, hasil_wawancara) VALUES
(1, '2023-09-16', '2023-09-17', 'CCTV, Metal Detector', 'Baut berasal dari traktor GSE. Petugas darat diberi peringatan.'),
(3, '2023-09-22', '2023-09-23', 'Calibration Records', 'Dipastikan alat sudah dikalibrasi ulang. Prosedur reminder diperbarui.');

INSERT INTO audit (id_karyawan, nomor_audit, judul, kategori, tanggal_pelaksanaan, keterangan) VALUES
(4, 'AUD-Q3-2023-001', 'Audit Kesiapan Ground Handling', 'Safety', '2023-08-01', 'Audit triwulanan rutin'),
(4, 'AUD-Q3-2023-002', 'Audit Dokumentasi Maintenance', 'Quality', '2023-08-15', 'Pemeriksaan kelengkapan logbook'),
(4, 'AUD-Q4-2023-001', 'Audit Keamanan Kargo', 'Security', '2023-10-01', 'Pemeriksaan proses screening kargo');

INSERT INTO temuan (id_audit, deskripsi_temuan, rekomendasi, status_tindak_lanjut) VALUES
(1, 'Beberapa APD (rompi) petugas ground handling sudah usang.', 'Segera lakukan pengadaan 15 rompi baru.', 'Completed'),
(1, 'Area parkir GSE tidak tertata rapi.', 'Buat demarkasi area parkir untuk setiap jenis GSE.', 'In Progress'),
(2, 'Terdapat 3 logbook yang pengisiannya tidak sesuai format.', 'Lakukan refreshment training kepada tim maintenance.', 'Completed'),
(3, 'Pintu gudang kargo tidak selalu terkunci.', 'Pasang sistem kunci otomatis dan alarm.', 'Open');

INSERT INTO library_manual (id_karyawan, judul_manual, tanggal_terbit, departemen_pemilik, status) VALUES
(3, 'Safety Management System Manual Rev. 3', '2023-01-01', 'Safety & Quality', 'Active'),
(5, 'Ground Handling Procedure Manual Rev. 5', '2022-06-15', 'Operations', 'Active'),
(1, 'B737 Flight Crew Operating Manual', '2021-02-20', 'Flight Operations', 'Active'),
(2, 'Bell 429 Maintenance Manual', '2020-11-10', 'Maintenance', 'Active'),
(4, 'Emergency Response Plan Rev. 2', '2023-05-30', 'Corporate Safety', 'Active');

-- =============================================================================
-- SELESAI
-- =============================================================================