-- Create the first database for properties
CREATE DATABASE IF NOT EXISTS venue_db;

-- Use the database 'venue_db' for properties
USE venue_db;



-- Create the 'users' table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    username VARCHAR(100) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),  -- Ensure passwords are hashed (bcrypt, etc.)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE users ADD COLUMN profile_image VARCHAR(255) NULL;

CREATE TABLE IF NOT EXISTS venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL CHECK (price >= 0), -- Ensures price is non-negative
    lat DECIMAL(10,6) NOT NULL,
    lng DECIMAL(10,6) NOT NULL,
    capacity INT NOT NULL CHECK (capacity > 0), -- Ensures capacity is positive
    tags VARCHAR(100) NOT NULL, -- Optimized storage
    category VARCHAR(255) NOT NULL,
    category2 ENUM('low price', 'mid price', 'high price') NOT NULL, -- Restricts values for consistency
    category3 ENUM('5', '10', '15', '20', '25') NOT NULL, -- Defines allowed capacity categories
    image VARCHAR(255) DEFAULT '/venue_locator/images/default_court.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Indexes for faster queries
    INDEX idx_category (category),
    INDEX idx_price_range (category2),
    INDEX idx_capacity_range (category3),
    INDEX idx_location (lat, lng)
);

-- Insert Data (Fixed syntax errors & improved consistency)
INSERT INTO venues (name, description, lat, lng, price, tags, capacity, category, category2, category3, image)
VALUES
('Molino 3 Bacoor Basketball Court', 'A well-maintained covered court.', 14.3914, 120.982, 500, '["High Price", "10 Person", "Covered Court"]', 10, 'Covered Court', 'high price', '10', '/venue_locator/images/image1.jpg'),
('Bacoor City Hall', 'Indoor basketball court with seating.', 14.3895, 120.984, 400, '["Low Price", "8 Person", "Covered Court"]', 8, 'Covered Court', 'low price', '8', '/venue_locator/images/image2.jpg'),
('San Lorenzo Ruiz Homes Covered Court', 'Spacious covered court.', 14.3808, 120.972, 450, '["High Price", "12 Person", "Covered Court"]', 12, 'Covered Court', 'high price', '12', '/venue_locator/images/courrtt.jpg'),
('Molino 1 (Progressive 18) Covered Court', 'Standard-sized basketball court.', 14.3925, 120.975, 350, '["Low Price", "6 Person", "Covered Court"]', 6, 'Covered Court', 'low price', '6', '/venue_locator/images/venue2.jpg'),
('Mary Homes Covered Basketball Court', 'Good for casual and league games.', 14.3928, 120.977, 500, '["High Price", "10 Person", "Covered Court"]', 10, 'Covered Court', 'high price', '10', '/venue_locator/images/venue2.jpg'),
('Garden City II Sunvar Village Basketball Court', 'Open to the public on weekdays.', 14.3999, 120.989, 300, '["Low Price", "6 Person", "Covered Court"]', 6, 'Covered Court', 'low price', '6', '/venue_locator/images/venue1.jpg'),
('LOWLAND COVERED COURT', 'Popular with local teams.', 14.4013, 120.995, 350, '["Low Price", "5 Person", "Covered Court"]', 5, 'Covered Court', 'low price', '5', '/venue_locator/images/venue2.jpg'),
('Console Village 9', 'A community-maintained court.', 14.4156, 120.977, 400, '["Low Price", "7 Person", "Covered Court"]', 7, 'Covered Court', 'low price', '7', '/venue_locator/images/venue1.jpg'),
('Iveys Court', 'Perfect for weekend games.', 14.4202, 120.963, 300, '["Low Price", "6 Person", "Covered Court"]', 6, 'Covered Court', 'low price', '6', '/venue_locator/images/court3.jpg'),
('Oval court Soldiers Hills 4', 'One of the largest courts in the area.', 14.4121, 120.980, 350, '["Low Price", "6 Person", "Covered Court"]', 6, 'Covered Court', 'low price', '6', '/venue_locator/images/venue2.jpg');


ALTER TABLE venues ADD COLUMN image_path VARCHAR(255) DEFAULT '/venue_locator/images/court.png';
-- Ensure the table exists

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venue_id INT NOT NULL,  -- Change from venue_name to venue_id for correct foreign key reference
    event_name VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    num_attendees INT NOT NULL CHECK (num_attendees > 0),
    total_cost DECIMAL(10,2) NOT NULL CHECK (total_cost >= 0),
    payment_method ENUM('Cash', 'Credit/Debit', 'Online') NOT NULL,
    shared_booking BOOLEAN NOT NULL DEFAULT FALSE,
    id_photo VARCHAR(255) NULL,
    status ENUM('Pending', 'Canceled') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE CASCADE
);

SELECT id, id_photo FROM bookings;
ALTER TABLE bookings MODIFY COLUMN status ENUM('Pending', 'Canceled', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending';



CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) 
VALUES ('admin', '1234'),
       ('admin1', '$2y$10$u6/l7p9YgZ0z5mLhFYxJbujGZ5r1qU6/78nX7N.R/FG81W7GJevsK');


CREATE TABLE user_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    username VARCHAR(100) UNIQUE,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    profile_image VARCHAR(255) NULL
);

SELECT COUNT(*) FROM users;

SELECT * FROM users;

SELECT COUNT(*) FROM users;

SELECT id, image FROM venues;



-- Insert sample admin user with hashed password ('admin' with password '1234')



-- Add status column separately