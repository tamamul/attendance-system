CREATE DATABASE IF NOT EXISTS attendance;
USE attendance;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(20)
);

CREATE TABLE attendances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    lat DOUBLE,
    lon DOUBLE,
    type VARCHAR(20),
    time TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@example.com','$2y$10$abcdefghijklmnopqrstuv','admin'),
('Demo User','demo@example.com','$2y$10$abcdefghijklmnopqrstuv','user');
