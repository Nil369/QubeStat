-- Sample Database Structure and Data for QubeStat
-- This script creates sample tables and inserts dummy data for testing

-- Drop tables if they exist
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS settings;

-- Create Users Table
-- Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    role ENUM('admin', 'user', 'manager') DEFAULT 'user',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    is_verified BOOLEAN DEFAULT FALSE,
    verification_code VARCHAR(255) DEFAULT NULL,
    reset_token VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (email),
    UNIQUE KEY (username)
);


-- Create Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    category VARCHAR(50),
    image_url VARCHAR(255),
    status ENUM('available', 'out_of_stock', 'discontinued') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'canceled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    shipping_address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Create Settings Table
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(50) NOT NULL,
    setting_value TEXT,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (setting_key)
);

-- Insert Sample Users
INSERT INTO users (username, email, password, first_name, last_name, role) VALUES
-- Insert Sample Users
INSERT INTO users (username, email, password, first_name, last_name, role, is_verified) VALUES
('admin', 'admin@qubestat.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', 'admin', TRUE),
('jsmith', 'john.smith@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Smith', 'user', FALSE),
('awhite', 'alice.white@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Alice', 'White', 'user', TRUE),
('rjohnson', 'robert.johnson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Robert', 'Johnson', 'manager', TRUE),
('mjane', 'mary.jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Mary', 'Jane', 'user', FALSE),
('dbrown', 'david.brown@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'David', 'Brown', 'user', TRUE),
('lgarcia', 'linda.garcia@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Linda', 'Garcia', 'manager', FALSE),
('mwilson', 'michael.wilson@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Michael', 'Wilson', 'user', TRUE),
('jdoe', 'jane.doe@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Doe', 'user', FALSE),
('tlee', 'tom.lee@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Tom', 'Lee', 'user', TRUE);

-- Insert Sample Products
INSERT INTO products (name, description, price, stock, category, image_url, status) VALUES
('Smartphone X', 'Latest model with advanced features', 999.99, 50, 'Electronics', 'img/products/smartphone-x.jpg', 'available'),
('Laptop Pro', '15-inch laptop with high performance', 1299.99, 25, 'Electronics', 'img/products/laptop-pro.jpg', 'available'),
('Wireless Earbuds', 'Premium sound quality with noise cancellation', 199.99, 100, 'Audio', 'img/products/wireless-earbuds.jpg', 'available'),
('Smart Watch', 'Track your fitness and receive notifications', 249.99, 75, 'Wearables', 'img/products/smart-watch.jpg', 'available'),
('4K TV', '55-inch 4K Ultra HD Smart TV', 699.99, 15, 'Electronics', 'img/products/4k-tv.jpg', 'available'),
('Bluetooth Speaker', 'Portable wireless speaker with 20-hour battery life', 79.99, 60, 'Audio', 'img/products/bluetooth-speaker.jpg', 'available'),
('Gaming Console', 'Next-gen gaming experience with 1TB storage', 499.99, 20, 'Gaming', 'img/products/gaming-console.jpg', 'available'),
('Digital Camera', 'Mirrorless camera with 24MP sensor', 799.99, 10, 'Photography', 'img/products/digital-camera.jpg', 'available'),
('Tablet Pro', '10-inch tablet with retina display', 399.99, 30, 'Electronics', 'img/products/tablet-pro.jpg', 'available'),
('Wireless Keyboard', 'Ergonomic design with backlit keys', 89.99, 40, 'Accessories', 'img/products/wireless-keyboard.jpg', 'available'),
('Wireless Mouse', 'Precision mouse with customizable buttons', 49.99, 45, 'Accessories', 'img/products/wireless-mouse.jpg', 'available'),
('External Hard Drive', '2TB portable hard drive', 129.99, 35, 'Storage', 'img/products/external-hard-drive.jpg', 'available'),
('Monitor', '27-inch 4K monitor with HDR', 349.99, 20, 'Electronics', 'img/products/monitor.jpg', 'available'),
('Printer', 'All-in-one wireless printer', 199.99, 15, 'Office', 'img/products/printer.jpg', 'out_of_stock'),
('Smart Home Hub', 'Control your smart home devices', 149.99, 25, 'Smart Home', 'img/products/smart-home-hub.jpg', 'available');

-- Insert Sample Orders
INSERT INTO orders (user_id, product_id, quantity, total_price, status, payment_method, shipping_address) VALUES
(2, 1, 1, 999.99, 'delivered', 'Credit Card', '123 Main St, Anytown, AN 12345'),
(3, 2, 1, 1299.99, 'shipped', 'PayPal', '456 Oak Ave, Somecity, SC 67890'),
(4, 3, 2, 399.98, 'processing', 'Credit Card', '789 Pine Rd, Otherville, OV 13579'),
(5, 4, 1, 249.99, 'pending', 'PayPal', '321 Elm Blvd, Somewhere, SW 24680'),
(6, 5, 1, 699.99, 'delivered', 'Credit Card', '654 Maple Dr, Anywhere, AW 97531'),
(7, 6, 3, 239.97, 'shipped', 'Credit Card', '987 Cedar Ln, Newtown, NT 86420'),
(8, 7, 1, 499.99, 'delivered', 'PayPal', '159 Birch St, Oldtown, OT 75319'),
(9, 8, 1, 799.99, 'canceled', 'Credit Card', '753 Spruce Ave, Uptown, UT 95135'),
(10, 9, 2, 799.98, 'processing', 'PayPal', '246 Willow Rd, Downtown, DT 15978'),
(2, 10, 1, 89.99, 'pending', 'Credit Card', '123 Main St, Anytown, AN 12345'),
(3, 11, 1, 49.99, 'delivered', 'PayPal', '456 Oak Ave, Somecity, SC 67890'),
(4, 12, 1, 129.99, 'processing', 'Credit Card', '789 Pine Rd, Otherville, OV 13579'),
(5, 13, 1, 349.99, 'shipped', 'PayPal', '321 Elm Blvd, Somewhere, SW 24680'),
(6, 14, 2, 399.98, 'pending', 'Credit Card', '654 Maple Dr, Anywhere, AW 97531'),
(7, 15, 1, 149.99, 'delivered', 'Credit Card', '987 Cedar Ln, Newtown, NT 86420');

-- Insert Sample Settings
INSERT INTO settings (setting_key, setting_value, description) VALUES
('site_name', 'QubeStat', 'The name of the site'),
('site_description', 'A full-stack LAMP application with XML/JSON API', 'Site meta description'),
('theme_color', '#6a1b9a', 'Primary theme color'),
('items_per_page', '10', 'Number of items to display per page'),
('enable_user_registration', 'true', 'Allow new users to register'),
('email_from', 'noreply@qubestat.com', 'Default from email address'),
('smtp_host', 'smtp.example.com', 'SMTP server hostname'),
('smtp_port', '587', 'SMTP server port'),
('smtp_encryption', 'tls', 'SMTP encryption type'),
('maintenance_mode', 'false', 'Site maintenance mode'); 