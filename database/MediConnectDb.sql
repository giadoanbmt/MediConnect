-- ========================================================
-- 1. TẠO VÀ CHỌN DATABASE
-- ========================================================
CREATE DATABASE IF NOT EXISTS MediConnectDb
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE MediConnectDb;

-- ========================================================
-- 2. CÁC BẢNG ĐỘC LẬP (BẢNG CHA)
-- ========================================================

-- 1. Bảng AccountUser
CREATE TABLE AccountUser (
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Gender VARCHAR(10) DEFAULT NULL,
    Address VARCHAR(255) DEFAULT NULL,
    AvatarUrl VARCHAR(500) DEFAULT NULL,
    Role TINYINT NOT NULL DEFAULT 2 COMMENT '1: Admin, 2: Patient',
    IsActive BOOLEAN DEFAULT 1 COMMENT '1: Online/Active, 0: Offline/Inactive',
    
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    DeletedAt DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Bảng City
CREATE TABLE City (
    CityId INT AUTO_INCREMENT PRIMARY KEY,
    CityName VARCHAR(100) NOT NULL,
    DistrictName VARCHAR(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Bảng Specialization (Đã bổ sung ImageUrl và Content)
CREATE TABLE Specialization (
    SpecializationId INT AUTO_INCREMENT PRIMARY KEY,
    SpecializationName VARCHAR(100) NOT NULL,
    Description TEXT DEFAULT NULL,
    ImageUrl VARCHAR(500) DEFAULT NULL,             -- Đường dẫn ảnh minh họa chuyên khoa
    Content LONGTEXT DEFAULT NULL                    -- Nội dung mô tả chi tiết chuyên khoa
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- 3. CÁC BẢNG PHỤ THUỘC CẤP 1
-- ========================================================

-- 4. Bảng ClinicRoom
CREATE TABLE ClinicRoom (
    RoomId INT AUTO_INCREMENT PRIMARY KEY,
    RoomName VARCHAR(100) NOT NULL,
    RoomNumber VARCHAR(20) NOT NULL,
    SpecializationId INT DEFAULT NULL,
    LocationFloor VARCHAR(50) DEFAULT NULL,
    IsActive TINYINT(1) DEFAULT 1,

    CONSTRAINT FK_ClinicRoom_Specialization FOREIGN KEY (SpecializationId) 
        REFERENCES Specialization(SpecializationId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Bảng Doctor
CREATE TABLE Doctor (
    DoctorId INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Gender VARCHAR(10) DEFAULT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    Qualifications VARCHAR(100) DEFAULT NULL,
    Address VARCHAR(255) DEFAULT NULL,
    AvatarUrl VARCHAR(500) DEFAULT NULL,
    
    CityId INT DEFAULT NULL,
    SpecializationId INT DEFAULT NULL,
    RoomId INT DEFAULT NULL,
  
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    DeletedAt DATETIME DEFAULT NULL,

    CONSTRAINT FK_Doctor_City FOREIGN KEY (CityId) REFERENCES City(CityId) ON DELETE SET NULL,
    CONSTRAINT FK_Doctor_Specialization FOREIGN KEY (SpecializationId) REFERENCES Specialization(SpecializationId) ON DELETE SET NULL,
    CONSTRAINT FK_Doctor_ClinicRoom FOREIGN KEY (RoomId) REFERENCES ClinicRoom(RoomId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- 4. CÁC BẢNG PHỤ THUỘC CẤP 2 (NGHIỆP VỤ CHÍNH)
-- ========================================================

-- 6. Bảng DoctorSchedule (Lịch làm việc Bác sĩ)
CREATE TABLE DoctorSchedule (
    ScheduleId BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DoctorId INT NOT NULL,
    WorkDate DATE NOT NULL,
    StartTime TIME NOT NULL,
    EndTime TIME NOT NULL,
    MaxPatients INT UNSIGNED DEFAULT 10,
    Status ENUM('Available', 'Full', 'Cancelled', 'Off') DEFAULT 'Available',
    Note VARCHAR(255) DEFAULT NULL,
    
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT FK_DoctorSchedule_Doctor 
        FOREIGN KEY (DoctorId) REFERENCES Doctor(DoctorId) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Bảng Appointment
CREATE TABLE Appointment (
    AppointmentId INT AUTO_INCREMENT PRIMARY KEY,
    UserId INT NOT NULL,
    DoctorId INT NOT NULL,
    RoomId INT DEFAULT NULL,
    
    AppointmentDate DATE NOT NULL,
    StartTime TIME NOT NULL,
    EndTime TIME NOT NULL,
    
    Status VARCHAR(20) DEFAULT 'Pending',
    Reason VARCHAR(255) DEFAULT NULL,
    CancellationReason VARCHAR(255) DEFAULT NULL,
    
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FK_Appointment_User FOREIGN KEY (UserId) REFERENCES AccountUser(UserId) ON DELETE CASCADE,
    CONSTRAINT FK_Appointment_Doctor FOREIGN KEY (DoctorId) REFERENCES Doctor(DoctorId) ON DELETE CASCADE,
    CONSTRAINT FK_Appointment_Room FOREIGN KEY (RoomId) REFERENCES ClinicRoom(RoomId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Bảng News
CREATE TABLE News (
    NewsId INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(300) NOT NULL,
    Category VARCHAR(100) DEFAULT NULL,
    Content LONGTEXT NOT NULL,
    ThumbnailUrl VARCHAR(500) DEFAULT NULL,
    
    AuthorType ENUM('Admin', 'Doctor') NOT NULL,
    UserId INT DEFAULT NULL,
    DoctorId INT DEFAULT NULL,
    
    PublishedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    IsPublished TINYINT(1) DEFAULT 1,
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    DeletedAt DATETIME DEFAULT NULL,

    CONSTRAINT FK_News_Admin FOREIGN KEY (UserId) REFERENCES AccountUser(UserId) ON DELETE SET NULL,
    CONSTRAINT FK_News_Doctor FOREIGN KEY (DoctorId) REFERENCES Doctor(DoctorId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Bảng ContactQuery
CREATE TABLE ContactQuery (
    QueryId INT AUTO_INCREMENT PRIMARY KEY,
    SenderName VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    Subject VARCHAR(200) DEFAULT NULL,
    MessageText TEXT NOT NULL,
    
    Status ENUM('Pending', 'Processing', 'Resolved') DEFAULT 'Pending',
    AdminNotes TEXT DEFAULT NULL,
    RespondedBy INT DEFAULT NULL,
    
    SubmittedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    RespondedAt DATETIME DEFAULT NULL,

    CONSTRAINT FK_ContactQuery_Admin FOREIGN KEY (RespondedBy) 
        REFERENCES AccountUser(UserId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE DoctorSchedule 
ADD COLUMN IsBooked BOOLEAN DEFAULT 0 COMMENT '0: Free/Unbooked, 1: Booked' AFTER Status;