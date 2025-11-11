CREATE DATABASE IF NOT EXISTS food_order_db;
USE food_order_db;

-- USERS
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('user','admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CATEGORIES
CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100)
);

-- FOOD ITEMS
CREATE TABLE IF NOT EXISTS food_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT,
  name VARCHAR(100),
  description TEXT,
  price DECIMAL(10,2),
  image VARCHAR(255),
  available TINYINT(1) DEFAULT 1,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- CART
CREATE TABLE IF NOT EXISTS cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  food_id INT,
  quantity INT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (food_id) REFERENCES food_items(id) ON DELETE CASCADE
);

-- ORDERS
CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total DECIMAL(10,2),
  status ENUM('Pending','Accepted','Preparing','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
  address VARCHAR(255),
  payment_method ENUM('COD','Online') DEFAULT 'COD',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- ORDER ITEMS
CREATE TABLE IF NOT EXISTS order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  food_id INT,
  quantity INT,
  price DECIMAL(10,2),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (food_id) REFERENCES food_items(id)
);

-- sample categories & items
INSERT INTO categories (name) VALUES ('Pizzas'), ('Burgers'), ('Drinks');

INSERT INTO food_items (category_id, name, description, price, image) VALUES
(1, 'Margherita Pizza', 'Classic cheese pizza', 249.00, 'pizza1.jpg'),
(1, 'Farmhouse Pizza', 'Veggie toppings', 299.00, 'pizza2.jpg'),
(2, 'Cheese Burger', 'Beef patty with cheese', 149.00, 'burger1.jpg'),
(2, 'Veg Burger', 'Paneer patty', 129.00, 'burger2.jpg'),
(3, 'Coke', '330ml bottle', 39.00, 'coke.jpg');

