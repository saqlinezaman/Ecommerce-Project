 
 CREATE TABLE inventory (
     id INT AUTO_INCREMENT PRIMARY KEY,
     product_id INT NOT NULL,
     change_type ENUM('in', 'out') NOT NULL,
     quantity INT NOT NULL,
     remark VARCHAR(255) DEFAULT NULL,
     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
 );