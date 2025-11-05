-- Create the database
CREATE DATABASE TastyCart;


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


-- Table: categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    description VARCHAR(150),
    date_creation DATETIME
);





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

-- Table: commend

CREATE TABLE command (
  id int PRIMARY KEY AUTO_INCREMENT,
  user_id int ,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  total decimal(10,2) NOT NULL,
  valid int NOT NULL DEFAULT 0,
  date_creation datetime NOT NULL DEFAULT current_timestamp()
)

-- Table: ling_commend
CREATE TABLE command_line (
    id int PRIMARY KEY AUTO_INCREMENT,
  product_id int NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  command_id int,
  FOREIGN KEY (command_id) REFERENCES command(id) ON DELETE CASCADE,
  prix decimal(10,2) NOT NULL,
  quantity int NOT NULL,
  total decimal(10,2) NOT NULL
)




USE TastyCart;
SELECT * FROM users;
SELECT * FROM categories;
select * FROM products;
select * FROM products;
select * FROM command;
select * FROM command_line;


ALTER TABLE categories ADD COLUMN icon VARCHAR(255) AFTER name;
ALTER TABLE users ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user';
UPDATE users SET role = 'admin' WHERE id = 14;

DELETE FROM users WHERE id = 13;











