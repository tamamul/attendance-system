-- Database: attendance_system
CREATE DATABASE IF NOT EXISTS attendance_system;
USE attendance_system;

-- Table: users
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'guru') DEFAULT 'guru',
    nip VARCHAR(50) NULL,
    phone VARCHAR(20) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: location_settings
CREATE TABLE location_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    radius INT NOT NULL COMMENT 'Radius in meters',
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Table: attendances
CREATE TABLE attendances (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type ENUM('in', 'out') NOT NULL,
    attendance_time TIMESTAMP NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    location_status ENUM('valid', 'invalid') NOT NULL,
    distance DECIMAL(8, 2) NULL COMMENT 'Distance from allowed location in meters',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table: personal_access_tokens
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Insert Dummy Data
INSERT INTO users (name, email, password, role, nip, phone, created_at, updated_at) VALUES
('Admin Sistem', 'admin@sekolah.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, '081234567890', NOW(), NOW()),
('Guru Matematika', 'guru.matematika@sekolah.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', '196510051992031001', '081234567891', NOW(), NOW()),
('Guru Bahasa', 'guru.bahasa@sekolah.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', '196812151995122001', '081234567892', NOW(), NOW()),
('Guru IPA', 'guru.ipa@sekolah.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'guru', '197203201998031002', '081234567893', NOW(), NOW());

INSERT INTO location_settings (latitude, longitude, radius, created_by, created_at, updated_at) VALUES
(-6.2087634, 106.845599, 100, 1, NOW(), NOW());

-- Insert Sample Attendance Data
INSERT INTO attendances (user_id, type, attendance_time, latitude, longitude, location_status, distance, created_at, updated_at) VALUES
(2, 'in', '2024-01-15 07:30:00', -6.2087634, 106.845599, 'valid', 15.50, NOW(), NOW()),
(2, 'out', '2024-01-15 16:15:00', -6.2087634, 106.845599, 'valid', 12.30, NOW(), NOW()),
(3, 'in', '2024-01-15 07:45:00', -6.2087634, 106.845599, 'valid', 18.75, NOW(), NOW()),
(3, 'out', '2024-01-15 16:20:00', -6.2087634, 106.845599, 'valid', 22.10, NOW(), NOW());