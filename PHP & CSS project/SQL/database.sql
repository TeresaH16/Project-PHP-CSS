CREATE DATABASE retro_store;
USE retro_store;

CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50),
                       email VARCHAR(100),
                       password VARCHAR(255)
);

CREATE TABLE products (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(100),
                          description TEXT,
                          price DECIMAL(10,2),
                          image VARCHAR(255)
);
