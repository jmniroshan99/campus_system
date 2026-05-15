-- Create Database
CREATE DATABASE IF NOT EXISTS campus_db;
USE campus_db;

-- Create Students Table
CREATE TABLE IF NOT EXISTS students (
    nic VARCHAR(12) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    address TEXT NOT NULL,
    contact VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    course VARCHAR(50) NOT NULL
);

-- Insert sample data
INSERT INTO students (nic, name, gender, address, contact, email, course) VALUES
('199512345678', 'John Doe', 'Male', '123 Main St, Colombo', '0771234567', 'john.doe@example.com', 'Computer Science'),
('199598765432', 'Jane Smith', 'Female', '456 Park Ave, Kandy', '0777654321', 'jane.smith@example.com', 'Information Technology'),
('200012345678', 'Mike Johnson', 'Male', '789 Hill Rd, Galle', '0779876543', 'mike.j@example.com', 'Software Engineering');

-- Create Admin Table (for login)
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insert default admin (username: admin, password: admin123)
INSERT INTO admin (username, password) VALUES ('admin', MD5('admin123'));