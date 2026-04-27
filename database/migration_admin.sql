-- Admin migration: add missing columns to users table
-- Run: Get-Content database\migration_admin.sql | c:\xampp\mysql\bin\mysql.exe -u citeworthydb -pHari_988420 worthycitdb

-- Add is_admin flag
ALTER TABLE users ADD COLUMN is_admin TINYINT(1) DEFAULT 0 AFTER email_notifications;

-- Add custom quota override columns
ALTER TABLE users ADD COLUMN custom_projects_limit INT DEFAULT NULL AFTER is_admin;
ALTER TABLE users ADD COLUMN custom_total_backlinks INT DEFAULT NULL AFTER custom_projects_limit;
ALTER TABLE users ADD COLUMN custom_analyzer_runs INT DEFAULT NULL AFTER custom_total_backlinks;

-- Expand plan ENUM to include 'elite'
ALTER TABLE users MODIFY COLUMN plan ENUM('free', 'starter', 'pro', 'enterprise', 'elite') DEFAULT 'free';
