-- Create the Database infirmary_scheduling_system
CREATE DATABASE infirmary_scheduling_system;

GO
    USE infirmary_scheduling_system;

GO
    -- Create the Table tbl_accounts
    CREATE TABLE tbl_accounts (
        id INT PRIMARY KEY IDENTITY(1, 1),
        created_at VARCHAR(19),
        modified_at VARCHAR(19),
        created_by VARCHAR(30),
        modified_by VARCHAR(30),
        name VARCHAR(30),
        username VARCHAR(30),
        password VARCHAR(255),
        user_type VARCHAR(10),
        is_verified INT
    );

-- Create the Table tbl_students
CREATE TABLE tbl_students (
    id INT PRIMARY KEY IDENTITY(1, 1),
    created_at VARCHAR(19),
    modified_at VARCHAR(19),
    created_by VARCHAR(30),
    modified_by VARCHAR(30),
    account_id INT,
    student_number VARCHAR(7),
    first_name VARCHAR(30),
    middle_name VARCHAR(30),
    last_name VARCHAR(30),
    email VARCHAR(30),
    program VARCHAR(50),
    school_branch VARCHAR(30),
    mobile_number VARCHAR(11),
    year_level VARCHAR(8)
);

-- Create the Table tbl_appointments
CREATE TABLE tbl_appointments (
    id INT PRIMARY KEY IDENTITY(1, 1),
    created_at VARCHAR(19),
    modified_at VARCHAR(19),
    created_by VARCHAR(30),
    modified_by VARCHAR(30),
    account_id INT,
    purpose_of_registration VARCHAR(20),
    appointment_date VARCHAR(11),
    appointment_time VARCHAR(8),
    status VARCHAR(9)
);

-- Insert default credentials for Administrator
INSERT INTO
    tbl_accounts (
        created_at,
        created_by,
        name,
        username,
        password,
        user_type,
        is_verified
    )
VALUES
    (
        '2024-04-19 03:15:00',
        'System',
        'Administrator',
        'admin',
        '$2y$10$Oh.Ez.38f6bxHKOGMp3puOsBlmd.JkUg2bzDFBcLxZGpqY5Q0R6LG',
        -- admin123
        'admin',
        1
    );

-- Insert default credentials for Sample Student
INSERT INTO
    tbl_accounts (
        created_at,
        created_by,
        name,
        password,
        user_type,
        is_verified
    )
VALUES
    (
        '2024-04-19 03:15:00',
        'System',
        'Juan Dela Cruz',
        '$2y$10$JHGAcYt4e663UvcPtA/r1uqP0Ea0VBtfbWEjYIhIoPCbH/Qwmxy7G',
        -- user1234
        'student',
        1
    );

-- Insert Sample Student data
INSERT INTO
    tbl_students (
        created_at,
        created_by,
        account_id,
        student_number,
        first_name,
        last_name,
        email,
        program,
        school_branch,
        mobile_number,
        year_level
    )
VALUES
    (
        '2024-04-19 03:15:00',
        'System',
        2,
        '1234567',
        'Juan',
        'Dela Cruz',
        'juandc@gmail.com',
        'Bachelor of Science in Information Technology',
        'Quezon City',
        '09123456789',
        '1st Year'
    );