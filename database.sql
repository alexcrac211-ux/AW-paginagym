CREATE DATABASE IF NOT EXISTS levi_supplements;
USE levi_supplements;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('Creatina', 'Proteína', 'Pre-entreno', 'Vitaminas') NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, category, description, price, image_url, stock) VALUES
('Titan Creatine Monohydrate', 'Creatina', 'Creatina ultra pura para fuerza explosiva. Siente el poder del Titan de Ataque en cada entrenamiento.', 29.99, './assets/creatine_tub_levi.png', 50),
('Scout Regiment Whey Protein', 'Proteína', 'Proteína aislada de rápida absorción. Recuperación para soldados de élite. Sabor Vainilla Colosal.', 45.99, './assets/protein_tub_levi.png', 40),
('Ackerman Pre-Workout', 'Pre-entreno', 'Energía inagotable y concentración letal. Prepárate para la batalla final en el gimnasio.', 34.99, './assets/preworkout_tub_levi.png', 30);
