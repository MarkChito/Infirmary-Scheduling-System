-- Create the Database infirmary_scheduling_system
CREATE DATABASE infirmary_scheduling_system;

GO
    USE infirmary_scheduling_system;

GO
    -- Create the Table tbl_accounts
    CREATE TABLE tbl_accounts (
        account_id INT PRIMARY KEY IDENTITY(1, 1),
        name VARCHAR(30),
        student_number VARCHAR(7),
        username VARCHAR(30),
        password VARCHAR(255),
        user_type VARCHAR(10)
    );

-- Create the Table tbl_students
CREATE TABLE tbl_students (
    student_id INT PRIMARY KEY IDENTITY(1, 1),
    student_number VARCHAR(7),
    name VARCHAR(30),
    email VARCHAR(30),
    program VARCHAR(4),
    school_branch VARCHAR(30),
    mobile_number VARCHAR(11),
    year_level VARCHAR(8),
);

-- Create the Table tbl_appointments
CREATE TABLE tbl_appointments (
    appointment_id INT PRIMARY KEY IDENTITY(1, 1),
    student_number VARCHAR(7),
    start_time VARCHAR(19),
    end_time VARCHAR(19),
);

-- Insert defualt credentials for Administrator
INSERT INTO
    tbl_accounts (
        name,
        student_number,
        username,
        password,
        user_type
    )
VALUES
    (
        'Administrator',
        '_null',
        'admin',
        '$2y$10$Oh.Ez.38f6bxHKOGMp3puOsBlmd.JkUg2bzDFBcLxZGpqY5Q0R6LG',
        'admin'
    );