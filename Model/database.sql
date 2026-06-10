-- Database: cook_with_soumi

CREATE DATABASE IF NOT EXISTS cook_with_soumi;
USE cook_with_soumi;

-- ======================
-- Categories table
-- ======================

CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(100) NOT NULL
);

-- ======================
-- Ingredients table
-- ======================

CREATE TABLE Ingredients (
    ingredient_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    stock INT NOT NULL
);

-- ======================
-- Recipes table
-- ======================

CREATE TABLE Recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    preparation_time TIME NOT NULL,
    category_id INT,

    FOREIGN KEY (category_id)
    REFERENCES Categories(category_id)
);

-- ======================
-- Recipe Ingredients table
-- Many-to-many relation
-- ======================

CREATE TABLE recipe_Ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ingredient_id INT NOT NULL,
    recipe_id INT NOT NULL,
    quantity INT NOT NULL,

    FOREIGN KEY (ingredient_id)
    REFERENCES Ingredients(ingredient_id),

    FOREIGN KEY (recipe_id)
    REFERENCES Recipes(recipe_id)
);

-- ======================
-- Users table
-- ======================

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    last_name VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ======================
-- Sample data
-- ======================

INSERT INTO Users
(last_name, first_name, email, password)
VALUES
('Amdouni', 'Soumaya', 'soumaya.amdouni.pro@gmail.com', '0'),

('Boudabbous', 'Fatma',
'bdbbs2000@gmail.com',
'$2y$10$zmzYEz6fCTssB.3UGTqD/.lCxP6uhpwX4jaLpuKDuRTCqSjxzLQBW');