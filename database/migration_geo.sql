-- GEO Optimizer Migration
-- Table to store content analyses and optimizations

CREATE TABLE IF NOT EXISTS geo_analyses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) DEFAULT 'Untitled Analysis',
    original_content MEDIUMTEXT NOT NULL,
    optimized_content MEDIUMTEXT DEFAULT NULL,
    readability_score FLOAT DEFAULT NULL,
    readability_suggestions TEXT DEFAULT NULL,
    keywords_json JSON DEFAULT NULL,
    aeo_gaps TEXT DEFAULT NULL,
    structure_suggestions TEXT DEFAULT NULL,
    schema_json JSON DEFAULT NULL,
    visual_suggestions TEXT DEFAULT NULL,
    linking_strategy TEXT DEFAULT NULL,
    meta_title VARCHAR(255) DEFAULT NULL,
    meta_description TEXT DEFAULT NULL,
    status ENUM('pending', 'analyzing', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;
