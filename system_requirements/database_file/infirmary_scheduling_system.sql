-- Create the Database infirmary_scheduling_system
CREATE DATABASE infirmary_scheduling_system;

GO
    USE infirmary_scheduling_system;

GO
    -- Create the Table tbl_accounts
    CREATE TABLE tbl_accounts (
        id INT PRIMARY KEY IDENTITY(1, 1),
        name VARCHAR(30),
        student_number VARCHAR(7),
        username VARCHAR(30),
        password VARCHAR(255),
        user_type VARCHAR(10)
    );

-- Create the Table tbl_students
CREATE TABLE tbl_students (
    id INT PRIMARY KEY IDENTITY(1, 1),
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
    id INT PRIMARY KEY IDENTITY(1, 1),
    student_id INT,
    day VARCHAR(9),
    start_time VARCHAR(19),
    end_time VARCHAR(19),
    status VARCHAR(8),
);

-- Create the Table tbl_available_schedules
CREATE TABLE tbl_available_schedules (
    id INT PRIMARY KEY IDENTITY(1, 1),
    day VARCHAR(9),
    start_time VARCHAR(19),
    end_time VARCHAR(19),
    status VARCHAR(13),
);

-- Insert default credentials for Administrator
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

-- Insert default credentials for Sample Student
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
        'Juan Dela Cruz',
        '1234567',
        '_null',
        '$2y$10$Oh.Ez.38f6bxHKOGMp3puOsBlmd.JkUg2bzDFBcLxZGpqY5Q0R6LG',
        'student'
    );

INSERT INTO
    tbl_students (
        student_number,
        name,
        email,
        program,
        school_branch,
        mobile_number,
        year_level
    )
VALUES
    (
        '1234567',
        'Juan Dela Cruz',
        'juan_dc@gmail.com',
        'BSIT',
        'Quezon City',
        '09123456789',
        '1st Year'
    );

-- Inserting values for Monday
INSERT INTO
    tbl_available_schedules (day, start_time, end_time, status)
VALUES
    ('Monday', '07:00', '08:00', 'Available'),
    ('Monday', '08:00', '09:00', 'Available'),
    ('Monday', '09:00', '10:00', 'Available'),
    ('Monday', '10:00', '11:00', 'Available'),
    ('Monday', '11:00', '12:00', 'Available'),
    ('Monday', '12:00', '13:00', 'Available'),
    ('Monday', '13:00', '14:00', 'Available'),
    ('Monday', '14:00', '15:00', 'Available'),
    ('Monday', '15:00', '16:00', 'Available'),
    ('Monday', '16:00', '17:00', 'Available');

-- Inserting values for Tuesday to Friday
INSERT INTO
    tbl_available_schedules (day, start_time, end_time, status)
SELECT
    'Tuesday',
    start_time,
    end_time,
    'Available'
FROM
    tbl_available_schedules
WHERE
    day = 'Monday';

INSERT INTO
    tbl_available_schedules (day, start_time, end_time, status)
SELECT
    'Wednesday',
    start_time,
    end_time,
    'Available'
FROM
    tbl_available_schedules
WHERE
    day = 'Monday';

INSERT INTO
    tbl_available_schedules (day, start_time, end_time, status)
SELECT
    'Thursday',
    start_time,
    end_time,
    'Available'
FROM
    tbl_available_schedules
WHERE
    day = 'Monday';

INSERT INTO
    tbl_available_schedules (day, start_time, end_time, status)
SELECT
    'Friday',
    start_time,
    end_time,
    'Available'
FROM
    tbl_available_schedules
WHERE
    day = 'Monday';