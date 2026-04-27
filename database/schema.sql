-- Worthycite SaaS Database Schema
-- Created: 2026-03-02

CREATE DATABASE IF NOT EXISTS worthycitdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE worthycitdb;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    plan ENUM('free', 'starter', 'pro', 'enterprise') DEFAULT 'free',
    avatar VARCHAR(255) DEFAULT NULL,
    email_notifications TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB;

-- Projects (Sites)
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    status ENUM('active', 'paused', 'archived') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- Backlinks
CREATE TABLE IF NOT EXISTS backlinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    source_url VARCHAR(2048) NOT NULL,
    target_url VARCHAR(2048) NOT NULL,
    anchor_text VARCHAR(500) DEFAULT NULL,
    status ENUM('active', 'lost', 'pending', 'warning') DEFAULT 'pending',
    link_type ENUM('dofollow', 'nofollow', 'ugc', 'sponsored') DEFAULT 'dofollow',
    da_score INT DEFAULT 0,
    acquired_date DATE DEFAULT NULL,
    last_checked TIMESTAMP NULL DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_status (status),
    INDEX idx_last_checked (last_checked)
) ENGINE=InnoDB;

-- Backlink Orders
CREATE TABLE IF NOT EXISTS backlink_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    target_url VARCHAR(2048) NOT NULL,
    desired_anchor VARCHAR(500) DEFAULT NULL,
    source_preference VARCHAR(2048) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    completed_backlink_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (completed_backlink_id) REFERENCES backlinks(id) ON DELETE SET NULL,
    INDEX idx_project (project_id),
    INDEX idx_status (status)
) ENGINE=InnoDB;

-- Alerts
CREATE TABLE IF NOT EXISTS alerts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_id INT DEFAULT NULL,
    backlink_id INT DEFAULT NULL,
    alert_type ENUM('anchor_missing', 'url_changed', '404_error', 'timeout', 'order_complete', 'report_ready') NOT NULL,
    severity ENUM('info', 'warning', 'critical') DEFAULT 'warning',
    message TEXT NOT NULL,
    details TEXT DEFAULT NULL,
    is_read TINYINT(1) DEFAULT 0,
    email_sent TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL,
    FOREIGN KEY (backlink_id) REFERENCES backlinks(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_read (is_read),
    INDEX idx_type (alert_type),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- LinkSquad Check Logs
CREATE TABLE IF NOT EXISTS linksquad_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    backlink_id INT NOT NULL,
    check_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    http_status INT DEFAULT NULL,
    anchor_found TINYINT(1) DEFAULT NULL,
    url_redirected TINYINT(1) DEFAULT 0,
    new_url VARCHAR(2048) DEFAULT NULL,
    response_time_ms INT DEFAULT NULL,
    error_message TEXT DEFAULT NULL,
    FOREIGN KEY (backlink_id) REFERENCES backlinks(id) ON DELETE CASCADE,
    INDEX idx_backlink (backlink_id),
    INDEX idx_date (check_date)
) ENGINE=InnoDB;

-- Monthly Reports
CREATE TABLE IF NOT EXISTS monthly_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_id INT DEFAULT NULL,
    report_month TINYINT NOT NULL,
    report_year SMALLINT NOT NULL,
    total_backlinks INT DEFAULT 0,
    new_backlinks INT DEFAULT 0,
    lost_backlinks INT DEFAULT 0,
    active_backlinks INT DEFAULT 0,
    avg_da DECIMAL(5,2) DEFAULT 0,
    report_data JSON DEFAULT NULL,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL,
    UNIQUE KEY unique_report (user_id, project_id, report_month, report_year),
    INDEX idx_user (user_id),
    INDEX idx_period (report_year, report_month)
) ENGINE=InnoDB;

-- Insert a demo user (password: demo123)
INSERT INTO users (name, email, password_hash, plan) VALUES
('Demo User', 'demo@worthycite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pro');
