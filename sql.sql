-- Active: 1754039895439@@127.0.0.1@3306@ecommerce
CREATE TABLE IF NOT EXISTS contact_message(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(200) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_replied INT DEFAULT 0,
    replied_text TEXT DEFAULT NULL,
    replied_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_contact_email ON contact_message(email);
CREATE INDEX idx_contact_is_replied ON contact_message(is_replied);