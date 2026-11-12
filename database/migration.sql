-- Upgrade an existing nexusolutions_db (the old software_agency.sql + add_payment.sql setup).
-- Run it once in phpMyAdmin (SQL tab) on the old database. Back it up first.
-- Needs the payment columns from add_payment.sql, which the old setup already had.
--
-- The two UNIQUE keys fail if two users share a username or an email.
-- Fix the duplicates by hand and run the script again from that line.

USE nexusolutions_db;

-- 1. users: no duplicate usernames or emails
ALTER TABLE users
  ADD UNIQUE KEY unique_username (username),
  ADD UNIQUE KEY unique_email (email);

-- 2. inquiries: link to users instead of matching on email
ALTER TABLE inquiries ADD COLUMN user_id INT DEFAULT NULL AFTER id;

UPDATE inquiries
  JOIN users ON users.email = inquiries.client_email
  SET inquiries.user_id = users.id;

ALTER TABLE inquiries
  ADD CONSTRAINT fk_inquiries_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
  ADD KEY index_payment_token (payment_token),
  ADD KEY index_status (status);

-- 3. login rate limiting
CREATE TABLE login_attempts (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  ip_address VARCHAR(45) DEFAULT NULL,
  attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY index_username_time (username, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. admin password: replace the plain text one with a bcrypt hash.
-- Temporary password: ChangeMe#2026 (change it after the first login).
UPDATE users
  SET password = '$2y$12$3pMSAIhpyUUDRwM58bEYSeAUbP0EyfDTPgMu8Vbe5WqVBQ.8W1EAS'
  WHERE username = 'admin' AND password NOT LIKE '$2y$%';
