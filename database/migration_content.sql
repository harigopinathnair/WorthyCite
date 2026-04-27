-- Content Analyses table
CREATE TABLE IF NOT EXISTS content_analyses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    url VARCHAR(2048) NOT NULL,
    overall_score INT DEFAULT 0,
    seo_score INT DEFAULT 0,
    geo_score INT DEFAULT 0,
    results_json JSON DEFAULT NULL,
    recommendations JSON DEFAULT NULL,
    page_title VARCHAR(500) DEFAULT NULL,
    word_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_score (overall_score),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;
