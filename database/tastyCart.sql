-- Create the database
CREATE DATABASE TastyCart;
DROP DATABASE TastyCart;

USE TastyCart;

-- Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(150),
    last_name VARCHAR(150),
    email VARCHAR(150) UNIQUE,
    password VARCHAR(150),
    date_creation DATETIME
);
DROP Table users;

-- Table: categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    description VARCHAR(150),
    date_creation DATETIME
);
DROP Table categories;




-- Table: products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    description VARCHAR(255),
    prix DECIMAL(10,2),
    discount int,
    image VARCHAR(255),
    category_id INT,
    date_creation DATETIME,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);


SELECT * FROM users;
SELECT * FROM categories;
select * FROM products;

ALTER TABLE categories ADD COLUMN icon VARCHAR(255) AFTER name;




