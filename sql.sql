-- Active: 1754039895439@@127.0.0.1@3306@ecommerce
CREATE TABLE categories(  
    id int(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE products(  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    product_name VARCHAR(255) NOT NULL,
    description TEXT,
    product_price DECIMAL(10, 2) NOT NULL,
    product_image VARCHAR(255),
    stock_amount int NOT NULL,
    has_attributes TINYINT(1),
    category_id int(6),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

INSERT INTO categories (category_name)
VALUES 
('Clothing'),
('Electronics'),
('Food & Beverages'),
('Furniture'),
('Books');

CREATE TABLE attributes(
    id int(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id int(6) NOT NULL,
    sizes VARCHAR(200) DEFAULT NULL,
    colors VARCHAR(200) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);