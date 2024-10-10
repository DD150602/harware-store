-- Drop database if it exists
DROP DATABASE IF EXISTS inventory_system;

-- Create new database
CREATE DATABASE inventory_system;

-- Use the created database
USE inventory_system;

-- Create roles table
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(255) NOT NULL,
    role_created_at DATETIME,
    role_updated_at DATETIME,
    role_deleted_at DATETIME
);

-- Create categories table
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(255) NOT NULL,
    category_created_at DATETIME,
    category_updated_at DATETIME,
    category_deleted_at DATETIME
);

-- Create suppliers table
CREATE TABLE suppliers (
    supplier_id INT PRIMARY KEY AUTO_INCREMENT,
    supplier_name VARCHAR(255) NOT NULL,
    supplier_contact VARCHAR(255) NOT NULL,
    supplier_phone VARCHAR(20) NOT NULL,
    supplier_address TEXT,
    supplier_created_at DATETIME,
    supplier_updated_at DATETIME,
    supplier_deleted_at DATETIME
);

-- Create clients table
CREATE TABLE clients (
    client_id INT PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(255) NOT NULL,
    client_phone VARCHAR(20) NOT NULL,
    client_address TEXT,
    client_created_at DATETIME,
    client_updated_at DATETIME,
    client_deleted_at DATETIME
);

-- Create users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(50) NOT NULL,
    user_lastname VARCHAR(60) NOT NULL,
    user_email VARCHAR(100) NOT NULL UNIQUE,
    user_username VARCHAR(40) NOT NULL,
    user_password VARCHAR(60) NOT NULL,
    user_status BOOLEAN DEFAULT TRUE,
    user_annotation TEXT,
    role_id INT NOT NULL,
    user_created_at DATETIME,
    user_updated_at DATETIME,
    user_deleted_at DATETIME,
    FOREIGN KEY (role_id) REFERENCES roles (role_id) ON DELETE CASCADE
);

-- Create products table with status and annotation fields
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(255) NOT NULL,
    product_description TEXT,
    product_price DECIMAL(10, 2) NOT NULL,
    product_stock INT NOT NULL,
    product_status BOOLEAN DEFAULT TRUE,
    product_annotation TEXT,
    category_id INT NOT NULL,
    supplier_id INT,
    product_created_at DATETIME,
    product_updated_at DATETIME,
    product_deleted_at DATETIME,
    FOREIGN KEY (category_id) REFERENCES categories (category_id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers (supplier_id) ON DELETE SET NULL
);

-- Create sales table
CREATE TABLE sales (
    sale_id INT PRIMARY KEY AUTO_INCREMENT,
    sale_total DECIMAL(10, 2) NOT NULL,
    sale_date DATE NOT NULL,
    client_id INT NOT NULL,
    user_id INT NOT NULL,
    sale_created_at DATETIME,
    sale_updated_at DATETIME,
    sale_deleted_at DATETIME,
    FOREIGN KEY (client_id) REFERENCES clients (client_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Create sale details table
CREATE TABLE sale_details (
    sale_detail_id INT PRIMARY KEY AUTO_INCREMENT,
    sale_quantity INT NOT NULL,
    sale_unit_price DECIMAL(10, 2) NOT NULL,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    sale_detail_created_at DATETIME,
    sale_detail_updated_at DATETIME,
    sale_detail_deleted_at DATETIME,
    FOREIGN KEY (sale_id) REFERENCES sales (sale_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE
);

-- Create purchases table
CREATE TABLE purchases (
    purchase_id INT PRIMARY KEY AUTO_INCREMENT,
    purchase_total DECIMAL(10, 2) NOT NULL,
    purchase_date DATE NOT NULL,
    supplier_id INT NOT NULL,
    user_id INT NOT NULL,
    purchase_created_at DATETIME,
    purchase_updated_at DATETIME,
    purchase_deleted_at DATETIME,
    FOREIGN KEY (supplier_id) REFERENCES suppliers (supplier_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Create purchase details table
CREATE TABLE purchase_details (
    purchase_detail_id INT PRIMARY KEY AUTO_INCREMENT,
    purchase_quantity INT NOT NULL,
    purchase_unit_price DECIMAL(10, 2) NOT NULL,
    purchase_id INT NOT NULL,
    product_id INT NOT NULL,
    purchase_detail_created_at DATETIME,
    purchase_detail_updated_at DATETIME,
    purchase_detail_deleted_at DATETIME,
    FOREIGN KEY (purchase_id) REFERENCES purchases (purchase_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE
);
