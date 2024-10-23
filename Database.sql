CREATE DATABASE absensi_db;

USE absensi_db;

CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'karyawan') NOT NULL
);

CREATE TABLE absensi (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    tanggal DATE NOT NULL,
    waktu_masuk TIME,
    waktu_keluar TIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
