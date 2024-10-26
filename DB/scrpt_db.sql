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

-- Create categories table
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(255) NOT NULL,
    category_created_at DATETIME,
    category_updated_at DATETIME,
    category_deleted_at DATETIME,
    category_created_by INT NOT NULL,
    FOREIGN KEY (category_created_by) REFERENCES users (user_id)
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
    supplier_deleted_at DATETIME,
    supplier_created_by INT NOT NULL,
    FOREIGN KEY (supplier_created_by) REFERENCES users (user_id)
);

-- Create clients table
CREATE TABLE clients (
    client_id INT PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(255) NOT NULL,
    client_phone VARCHAR(20) NOT NULL,
    client_address TEXT,
    client_created_at DATETIME,
    client_updated_at DATETIME,
    client_deleted_at DATETIME,
    client_created_by INT NOT NULL,
    FOREIGN KEY (client_created_by) REFERENCES users (user_id)
);

-- Create products table
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
    product_created_by INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (category_id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers (supplier_id) ON DELETE SET NULL,
    FOREIGN KEY (product_created_by) REFERENCES users (user_id)
);

-- Create sales table
CREATE TABLE sales (
    sale_id INT PRIMARY KEY AUTO_INCREMENT,
    sale_total DECIMAL(10, 2) NOT NULL,
    sale_date DATETIME NOT NULL,
    client_id INT NOT NULL,
    user_id INT NOT NULL,
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
    purchase_date DATETIME NOT NULL,
    supplier_id INT NOT NULL,
    user_id INT NOT NULL,
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

-- Create Auditory table
CREATE TABLE audits (
    audit_id INT PRIMARY KEY AUTO_INCREMENT,
    audit_type VARCHAR(10) NOT NULL,
    audit_table VARCHAR(60) NOT NULL,
    audit_date DATETIME NOT NULL,
    audit_detail TEXT NOT NULL
);

DELIMITER $$
-- Trigger for INSERT operation on categories
CREATE TRIGGER trg_categories_insert
AFTER INSERT ON categories
FOR EACH ROW
BEGIN
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('INSERT', 'categories', NOW(), CONCAT('Category added: ', NEW.category_name, ' by: ', NEW.category_created_by));
END;

-- Trigger for UPDATE operation on categories
CREATE TRIGGER trg_categories_update
AFTER UPDATE ON categories
FOR EACH ROW
BEGIN
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('UPDATE', 'categories', NOW(), CONCAT('Category updated: ', OLD.category_name, ' to ', NEW.category_name, ' by: ', OLD.category_created_by));
END;

-- Trigger for INSERT operation on suppliers
CREATE TRIGGER trg_suppliers_insert
AFTER INSERT ON suppliers
FOR EACH ROW
BEGIN
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('INSERT', 'suppliers', NOW(), CONCAT('Supplier added: ', NEW.supplier_name, ', by: ', NEW.supplier_created_by));
END;

-- Trigger for UPDATE operation on suppliers
CREATE TRIGGER trg_suppliers_update
AFTER UPDATE ON suppliers
FOR EACH ROW
BEGIN
    DECLARE new_string TEXT DEFAULT '';
    DECLARE new_sname TEXT DEFAULT '';
    DECLARE new_scontact TEXT DEFAULT '';
    DECLARE new_sphone TEXT DEFAULT '';
    DECLARE new_saddress TEXT DEFAULT '';

    -- Check for changes and prepare messages
    IF OLD.supplier_name <> NEW.supplier_name THEN
        SET new_sname = CONCAT('Supplier name changed from ', OLD.supplier_name, ' to ', NEW.supplier_name, '. ');
    END IF;

    IF OLD.supplier_contact <> NEW.supplier_contact THEN
        SET new_scontact = CONCAT('Supplier contact changed from ', OLD.supplier_contact, ' to ', NEW.supplier_contact, '. ');
    END IF;

    IF OLD.supplier_phone <> NEW.supplier_phone THEN
        SET new_sphone = CONCAT('Supplier phone changed from ', OLD.supplier_phone, ' to ', NEW.supplier_phone, '. ');
    END IF;

    IF OLD.supplier_address <> NEW.supplier_address THEN
        SET new_saddress = CONCAT('Supplier address changed from ', OLD.supplier_address, ' to ', NEW.supplier_address, '. ');
    END IF;

    -- Concatenate all changes into one string
    SET new_string = CONCAT(
        'Supplier updated: ',
        IFNULL(new_sname, ''),
        IFNULL(new_scontact, ''),
        IFNULL(new_sphone, ''),
        IFNULL(new_saddress, ''),
        'Updated by user ID: ', NEW.supplier_created_by
    );

    -- Insert audit record
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('UPDATE', 'suppliers', NOW(), new_string);
END;


-- Trigger for INSERT operation on clients
CREATE TRIGGER trg_clients_insert
AFTER INSERT ON clients
FOR EACH ROW
BEGIN
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('INSERT', 'clients', NOW(), CONCAT('Client added: ', NEW.client_name, ' by: ', NEW.client_created_by));
END;

-- Trigger for UPDATE operation on clients
CREATE TRIGGER trg_clients_update
AFTER UPDATE ON clients
FOR EACH ROW
BEGIN
    DECLARE new_string TEXT DEFAULT '';
    DECLARE new_cname TEXT DEFAULT '';
    DECLARE new_cphone TEXT DEFAULT '';
    DECLARE new_caddress TEXT DEFAULT '';

    -- Check for changes and prepare messages
    IF OLD.client_name <> NEW.client_name THEN
        SET new_cname = CONCAT('Client name changed from ', OLD.client_name, ' to ', NEW.client_name, '. ');
    END IF;

    IF OLD.client_phone <> NEW.client_phone THEN
        SET new_cphone = CONCAT('Client phone changed from ', OLD.client_phone, ' to ', NEW.client_phone, '. ');
    END IF;

    IF OLD.client_address <> NEW.client_address THEN
        SET new_caddress = CONCAT('Client address changed from ', OLD.client_address, ' to ', NEW.client_address, '. ');
    END IF;

    -- Concatenate changes into a single string
    SET new_string = CONCAT(
        IFNULL(new_cname, ''), 
        IFNULL(new_cphone, ''), 
        IFNULL(new_caddress, ''),
        'Updated by user ID: ', NEW.client_created_by
    );

    -- Insert into audits table
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('UPDATE', 'clients', NOW(), new_string);
END;


-- Trigger for INSERT operation on products
CREATE TRIGGER trg_products_insert
AFTER INSERT ON products
FOR EACH ROW
BEGIN
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('INSERT', 'products', NOW(), CONCAT('Product added: ', NEW.product_name, ' by: ', NEW.product_created_by));
END;

-- Trigger for UPDATE operation on products
CREATE TRIGGER trg_products_update
AFTER UPDATE ON products
FOR EACH ROW
BEGIN
    DECLARE new_string TEXT DEFAULT '';
    DECLARE new_pname TEXT DEFAULT '';
    DECLARE new_pdesc TEXT DEFAULT '';
    DECLARE new_pprice TEXT DEFAULT '';
    DECLARE new_pstock TEXT DEFAULT '';
    DECLARE new_pstatus TEXT DEFAULT '';
    DECLARE new_pannot TEXT DEFAULT '';

    -- Check for changes and prepare messages
    IF OLD.product_name <> NEW.product_name THEN
        SET new_pname = CONCAT('Product name changed from ', OLD.product_name, ' to ', NEW.product_name, '. ');
    END IF;

    IF OLD.product_description <> NEW.product_description THEN
        SET new_pdesc = CONCAT('Product description changed from ', OLD.product_description, ' to ', NEW.product_description, '. ');
    END IF;

    IF OLD.product_price <> NEW.product_price THEN
        SET new_pprice = CONCAT('Product price changed from ', OLD.product_price, ' to ', NEW.product_price, '. ');
    END IF;

    IF OLD.product_stock <> NEW.product_stock THEN
        SET new_pstock = CONCAT('Product stock changed from ', OLD.product_stock, ' to ', NEW.product_stock, '. ');
    END IF;

    IF OLD.product_status <> NEW.product_status THEN
        SET new_pstatus = CONCAT('Product status changed from ', OLD.product_status, ' to ', NEW.product_status, '. ');
    END IF;

    IF OLD.product_annotation <> NEW.product_annotation THEN
        SET new_pannot = CONCAT('Product annotation changed from ', OLD.product_annotation, ' to ', NEW.product_annotation, '. ');
    END IF;

    -- Concatenate all changes into one string
    SET new_string = CONCAT(
        'Product updated: ',
        IFNULL(new_pname, ''),
        IFNULL(new_pdesc, ''),
        IFNULL(new_pprice, ''),
        IFNULL(new_pstock, ''),
        IFNULL(new_pstatus, ''),
        IFNULL(new_pannot, ''),
        'Updated by user ID: ', NEW.product_created_by
    );

    -- Insert audit record
    INSERT INTO audits (audit_type, audit_table, audit_date, audit_detail)
    VALUES ('UPDATE', 'products', NOW(), new_string);
END;

$$
DELIMITER ;