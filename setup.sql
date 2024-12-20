-- Create Crops Table
CREATE TABLE crops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crop_name VARCHAR(255) NOT NULL
);

-- Insert Example Crop Data
INSERT INTO crops (crop_name)
VALUES ('Wheat'), ('Rice'), ('Corn'),('Tomato');

-- Create Transport Table with 'last_updated' column
CREATE TABLE transport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transport_name VARCHAR(255) NOT NULL,
    tracking_number VARCHAR(255) NOT NULL,
    latitude DECIMAL(9,6) NOT NULL,  -- Changed to DECIMAL for better precision
    longitude DECIMAL(9,6) NOT NULL, -- Changed to DECIMAL for better precision
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Automatically updates on record modification
);

-- Insert Transport Records with Latitude and Longitude
INSERT INTO transport (transport_name, tracking_number, latitude, longitude)
VALUES 
    ('Truck A', 'TRK12345', -34.397, 150.644),
    ('Truck B', 'TRK67890', -34.500, 150.700);

-- Create Packages Table with Description column
CREATE TABLE packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    package_name VARCHAR(255) NOT NULL,
    package_description TEXT,  -- Added the description field as TEXT
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Step 1: Alter the table to add the 'description' column
ALTER TABLE packages ADD COLUMN description TEXT NOT NULL;

-- Step 2: Insert data into the table
INSERT INTO packages (package_name, package_description) 
VALUES 
    ('Package 1', 'Description for Package 1'),
    ('Package 2', 'Description for Package 2');


-- Create Grades Table
CREATE TABLE grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    crop_id INT NOT NULL,
    grade VARCHAR(50) NOT NULL,
    inspector_id INT NOT NULL,
    inspection_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (crop_id) REFERENCES crops(id)
);

-- Insert Example Grading Data
INSERT INTO grades (crop_id, grade, inspector_id) 
VALUES 
    (1, 'A', 1),
    (2, 'B', 2),
    (3, 'A', 1);

-- Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL DEFAULT 'user',  -- Added role directly during table creation
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Example User Data (Ensure you change passwords in a real-world scenario)
INSERT INTO users (username, password, email)
VALUES 
    ('admin', 'adminpassword', 'admin@example.com'),
    ('user1', 'userpassword', 'user1@example.com');
