-- base_schema.sql

-- CREATE TABLE institutions (
--     -- Primary Key
--     id INT AUTO_INCREMENT PRIMARY KEY,

--     -- Basic Details
--     name VARCHAR(255) NOT NULL,
--     database_name VARCHAR(255) NOT NULL,
--     email VARCHAR(255) UNIQUE NOT NULL,
--     phone_number VARCHAR(20) UNIQUE NOT NULL,
--     website_url VARCHAR(255), -- Optional: for the institution's website

--     -- Address Details
--     address VARCHAR(255) NOT NULL,
--     city VARCHAR(100),
--     state VARCHAR(100),
--     postal_code VARCHAR(20),
--     country VARCHAR(100) DEFAULT 'India',

--     uploads_folder_path VARCHAR(255) NOT NULL,


--     -- Branding and Limits
--     logo_url TEXT,

--     -- Timestamps
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

--     -- Indexes
--     INDEX (email)
-- );



-- roles table
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

INSERT INTO roles (name) VALUES
('admin'),
('teacher'),
('student'),
('parent'),
('accountant'),
('receptionist'),
('driver');

CREATE TABLE root_user (
    -- id INT PRIMARY KEY DEFAULT 1 CHECK (super_admin_id = 1),

    -- institute_name VARCHAR(100) NOT NULL,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,

    -- permissions JSON NOT NULL,

    role VARCHAR(100) NOT NULL DEFAULT 'root' CHECK (role = 'root'),

    -- Singleton constraint to enforce one-row table
    singleton CHAR(1) DEFAULT 'X' UNIQUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    phone_number VARCHAR(20),


    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
