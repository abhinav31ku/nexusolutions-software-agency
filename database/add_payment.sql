-- Run this ONCE in phpMyAdmin (database: nexusolutions_db, tab: SQL) after importing software_agency.sql
ALTER TABLE `inquiries`
  ADD COLUMN `amount` DECIMAL(10,2) NOT NULL DEFAULT 0,
  ADD COLUMN `payment_status` VARCHAR(20) NOT NULL DEFAULT 'Unpaid',
  ADD COLUMN `payment_token` VARCHAR(64) DEFAULT NULL,
  ADD COLUMN `paid_at` TIMESTAMP NULL DEFAULT NULL;
