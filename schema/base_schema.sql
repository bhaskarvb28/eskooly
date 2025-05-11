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
('accountant');

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

CREATE TABLE staff (
	id INT AUTO_INCREMENT PRIMARY KEY,
	
	role_id INT,
	first_name VARCHAR(50),
	last_name VARCHAR(50),
	designation VARCHAR(50),
	
	father_name VARCHAR(50),
	mother_name VARCHAR(50),
	
	email VARCHAR(100) UNIQUE,
	gender ENUM('Male', 'Female', 'Other') DEFAULT 'Other',
	
	date_of_birth DATE,
	date_of_joining DATE,
	
	mobile VARCHAR(15),
	emergency_mobile VARCHAR(15),
	
	staff_photo VARCHAR(255),
	driving_license VARCHAR(15),
	
	current_address TEXT,
	permanent_address TEXT,
	
	qualifications VARCHAR(100),
	experience INT,
	
	epf_number VARCHAR(50),
	basic_salary DECIMAL(10, 2),
	
	bank_account_name VARCHAR(100),
	bank_account_number VARCHAR(50),
	bank_name VARCHAR(100),
	branch_name VARCHAR(100),
	
	facbook_url VARCHAR(255),
	twitter_url VARCHAR(255),
	linkedin_url VARCHAR(255),
	instagram_url VARCHAR(255),
	
	resume VARCHAR(255),
	joining_letter VARCHAR(255),
	other_documents VARCHAR(255),

    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL
);

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    subject_code VARCHAR(20) NOT NULL UNIQUE,  -- e.g., "MATH101"
    subject_name VARCHAR(100) NOT NULL,        -- e.g., "Mathematics"
    academic_year VARCHAR(20),
    subject_type ENUM('Theory', 'Practical', 'Lab', 'Project') DEFAULT 'Theory',
    
    description TEXT DEFAULT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    staff_id INT NOT NULL, -- Reference to the main staff table
    department VARCHAR(100),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
);

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    class_name VARCHAR(50) NOT NULL,      -- e.g., "10th Grade"
    section VARCHAR(10),                  -- e.g., "A", "B"
    
    academic_year VARCHAR(20),        -- Foreign key to academic_years
    
    class_teacher_id INT DEFAULT NULL,    -- Optional class in-charge
    
    FOREIGN KEY (class_teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
);

CREATE TABLE teacher_class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    class_id INT NOT NULL,
    subject_id INT DEFAULT NULL,
    academic_year VARCHAR(20),

    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL
);