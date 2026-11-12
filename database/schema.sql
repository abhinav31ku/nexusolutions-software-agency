-- Nexusolutions database. Import this into a fresh database.
-- Existing database? Use migration.sql instead.

CREATE DATABASE IF NOT EXISTS nexusolutions_db CHARACTER SET utf8mb4;
USE nexusolutions_db;

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(100) DEFAULT NULL,
  contact_no VARCHAR(20) DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY unique_username (username),
  UNIQUE KEY unique_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE inquiries (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT DEFAULT NULL,
  client_name VARCHAR(100) NOT NULL,
  client_email VARCHAR(100) NOT NULL,
  contact_no VARCHAR(20) DEFAULT NULL,
  service_type VARCHAR(50) NOT NULL,
  message TEXT DEFAULT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Pending',
  amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  payment_status VARCHAR(20) NOT NULL DEFAULT 'Unpaid',
  payment_token VARCHAR(64) DEFAULT NULL,
  paid_at TIMESTAMP NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY index_payment_token (payment_token),
  KEY index_status (status),
  CONSTRAINT fk_inquiries_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE login_attempts (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY index_username_time (username, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin account. Temporary password: ChangeMe#2026 (change it after the first login).
INSERT INTO users (username, email, contact_no, password, role) VALUES
('admin', 'admin@nexusolutions.com', '+91 98765 43210', '$2y$12$3pMSAIhpyUUDRwM58bEYSeAUbP0EyfDTPgMu8Vbe5WqVBQ.8W1EAS', 'admin');
