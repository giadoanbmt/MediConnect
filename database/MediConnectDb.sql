-- ========================================================
-- 1. TẠO VÀ CHỌN DATABASE
-- ========================================================
CREATE DATABASE IF NOT EXISTS MediConnectDb
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE MediConnectDb;


CREATE TABLE AccountUser (
    UserId INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL, -- Độ dài 255 phù hợp lưu password đã hash (Bcrypt, Argon2, v.v.)
    Gender VARCHAR(10) DEFAULT NULL, -- Đổi từ 'sex' -> 'Gender' (Chuẩn tiếng Anh thông dụng)
    Address VARCHAR(255) DEFAULT NULL,
    AvatarUrl VARCHAR(500) DEFAULT NULL, -- Đổi từ 'url_image' -> 'AvatarUrl' (Trực quan, dễ hiểu)
    Role TINYINT NOT NULL DEFAULT 2 COMMENT '1: Admin, 2: Patient',
    
    -- Các trường Audit / Soft Delete
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    DeletedAt DATETIME DEFAULT NULL -- Phục vụ xóa mềm (Soft Delete)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

create table Specialization(
	SpecializationId int primary key IDENTITY(1,1) not null,
	SpecializationName varchar(100) not null,
	Description varchar(max)
)

CREATE TABLE Doctor (
    DoctorId INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100) NOT NULL,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Gender VARCHAR(10) DEFAULT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    Qualifications VARCHAR(100) DEFAULT NULL, -- Đổi từ 'bangcap' -> Qualifications (Bằng cấp/Trình độ)
    RoomId INT DEFAULT NULL,     -- Đổi từ 'phonglamviec' -> RoomNumber (Phòng làm việc/Phòng khám)
    Address VARCHAR(255) DEFAULT NULL,
    SpecializationId INT DEFAULT NULL,        -- Khóa ngoại kết nối với bảng Chuyên khoa
    AvatarUrl VARCHAR(500) DEFAULT NULL,
  
    -- Các trường Audit / Soft Delete
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    DeletedAt DATETIME DEFAULT NULL,

    -- Ràng buộc khóa ngoại
    CONSTRAINT FK_Doctor_City FOREIGN KEY (CityId) REFERENCES City(CityId) ON DELETE SET NULL,
    CONSTRAINT FK_Doctor_Specialization FOREIGN KEY (SpecializationId) REFERENCES Specialization(SpecializationId) ON DELETE SET NULL,
    CONSTRAINT FK_Doctor_City FOREIGN KEY (CityId) REFERENCES City(CityId) ON DELETE SET NULL
    CONSTRAINT FK_Doctor_ClinicRoom FOREIGN KEY (RoomId) REFERENCES ClinicRoom(RoomId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE City (
    CityId INT AUTO_INCREMENT PRIMARY KEY,
    CityName VARCHAR(100) NOT NULL,       -- Đổi từ 'name' -> CityName
    DistrictName VARCHAR(100) DEFAULT NULL -- Đổi từ 'quan/huyen' -> DistrictName
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE ClinicRoom (
    RoomId INT AUTO_INCREMENT PRIMARY KEY,
    RoomName VARCHAR(100) NOT NULL,        -- Đổi từ 'name' -> RoomName (VD: Phòng khám Tai Mũi Họng 1)
    RoomNumber VARCHAR(20) NOT NULL,       -- Đổi từ 'sophong' -> RoomNumber (VD: P.101, A-202)
    SpecializationId INT DEFAULT NULL,     -- Khóa ngoại nối đến bảng Specialization
    LocationFloor VARCHAR(50) DEFAULT NULL, -- Tầng/Khu vực (VD: Tầng 2 - Tòa nhà A)
    IsActive TINYINT(1) DEFAULT 1,         -- Trạng thái phòng (1: Hoạt động, 0: Đang bảo trì)

    -- Ràng buộc khóa ngoại
    CONSTRAINT FK_ClinicRoom_Specialization FOREIGN KEY (SpecializationId) 
        REFERENCES Specialization(SpecializationId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Appointment (
    AppointmentId INT AUTO_INCREMENT PRIMARY KEY,
    UserId INT NOT NULL,                     -- Khóa ngoại kết nối với AccountUser (Bệnh nhân)
    DoctorId INT NOT NULL,                   -- Khóa ngoại kết nối với Doctor
    RoomId INT DEFAULT NULL,                 -- Khóa ngoại kết nối với ClinicRoom (Phòng khám)
    
    AppointmentDate DATE NOT NULL,           -- Ngày khám (ngaykham)
    StartTime TIME NOT NULL,                 -- Giờ bắt đầu (thoigianbatdau)
    EndTime TIME NOT NULL,                   -- Giờ kết thúc (thoigianketthuc)
    
    Status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') DEFAULT 'Pending', -- Trạng thái (trangthai: Chờ, Xác nhận, Hoàn thành, Hủy)
    Reason VARCHAR(255) DEFAULT NULL,        -- Lý do khám (lydokham)
    CancellationReason VARCHAR(255) DEFAULT NULL, -- Lý do hủy (lydohuy)
    
    -- Các trường Audit
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP, -- Ngày đặt lịch (ngaydat)
    UpdatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Ràng buộc khóa ngoại
    CONSTRAINT FK_Appointment_User FOREIGN KEY (UserId) REFERENCES AccountUser(UserId) ON DELETE CASCADE,
    CONSTRAINT FK_Appointment_Doctor FOREIGN KEY (DoctorId) REFERENCES Doctor(DoctorId) ON DELETE CASCADE,
    CONSTRAINT FK_Appointment_Room FOREIGN KEY (RoomId) REFERENCES ClinicRoom(RoomId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE News (
    NewsId INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(300) NOT NULL,
    Category VARCHAR(100) DEFAULT NULL,
    Content LONGTEXT NOT NULL,
    ThumbnailUrl VARCHAR(500) DEFAULT NULL, -- Đường dẫn ảnh minh họa (Cho phép NULL nếu không chọn)
    
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

CREATE TABLE ContactQuery (
    QueryId INT AUTO_INCREMENT PRIMARY KEY,
    SenderName VARCHAR(100) NOT NULL,             -- Đổi từ 'Name' -> SenderName để tránh trùng từ khóa hệ thống
    Email VARCHAR(100) NOT NULL,
    PhoneNumber VARCHAR(20) NOT NULL,
    Subject VARCHAR(200) DEFAULT NULL,            -- Tiêu đề/Chủ đề liên hệ
    MessageText TEXT NOT NULL,                    -- Nội dung tin nhắn (Đổi varchar(max) -> TEXT)
    
    -- Các cột bổ sung phục vụ quản lý & CSKH
    Status ENUM('Pending', 'Processing', 'Resolved') DEFAULT 'Pending', -- Trạng thái xử lý
    AdminNotes TEXT DEFAULT NULL,                 -- Ghi chú nội bộ của Admin/CSKH khi xử lý
    RespondedBy INT DEFAULT NULL,                 -- Admin nào đảm nhận phản hồi
    
    SubmittedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    RespondedAt DATETIME DEFAULT NULL,            -- Thời điểm hoàn tất xử lý

    -- Ràng buộc khóa ngoại đến bảng Admin
    CONSTRAINT FK_ContactQuery_Admin FOREIGN KEY (RespondedBy) 
        REFERENCES AccountUser(UserId) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;