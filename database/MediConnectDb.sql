create database MediConnect


create table AccountUser (
	UserId int primary key IDENTITY(1,1) not null,
	Username varchar(100) not null,
	Password varchar(max) not null,
	Email varchar(100) not null,
	Role int not null Default(2), -- 1: Admin, 2: Patient
	IsActive Bit default(1), -- 1: true, 0: false
	CreatedAt Datetime Default(Getdate())
)

create table City (
	CityId int primary key IDENTITY(1,1) not null,
	City varchar(50) not null
)

create table Specialization(
	SpecializationId int primary key IDENTITY(1,1) not null,
	SpecializationName varchar(100) not null,
	Description varchar(max)
)

create table Doctor (
	DoctorId int primary key IDENTITY(1,1) not null,
	DoctorName varchar(50) not null,
	DoctorAccount varchar (100) not null,
	Password varchar(max) not null,
	Sex varchar(50),
	PhoneNumber varchar(20) not null,
	Email varchar(100) not null,
	SpecializationId int, -- Mã chuyên ngành
	Qualifications varchar(50) not null, --Trình độ học vấn
	CityId int, -- Mã thành phố
	Address varchar(max) not null,
    Foreign key (CityId) references City(CityId) ON DELETE SET NULL,
	Foreign key (SpecializationId) references Specialization(SpecializationId) on delete set null
)

create table Appointment (
	AppointmentId int primary key IDENTITY(1,1),
	DoctorId int not null,
	UserId int Default(null), -- Để null khi khung giờ đang Available nhưng chưa có bệnh nhân đặt
	AvailableDate Date not null, -- Những khung giờ available do bác sĩ đặt mà bệnh nhân có thể book
	AppointmentDate Date, -- Ngày hẹn. Nếu khách chọn thời gian trùng vs AppointmentDate đã có thì ko thể đặt lịch
	StartTime Time not null,
	EndTime Time not null,
	Status varchar(20) 
		check(status in ('Available', 'Booked', 'Completed', 'Canceled')) Default('Available'),
	Foreign key (UserId) references AccountUser(UserId),
	Foreign key (DoctorId) references Doctor(DoctorId)
)


create table Content( -- Bảng quản lý các content xuất hiện trên phần blog, homepage
	ContentId int primary key IDENTITY(1,1) not null,
	Title varchar(300) not null,
	Category varchar(50),
	Body varchar(max) not null,
	PublishedBy int Default(null), -- Id người đăng bài
	PublishedAt Datetime Default(Getdate()),
	Foreign key (PublishedBy) references Doctor(DoctorId) on delete set null
)

create table ContactQuerie(
	QueryId int primary key IDENTITY(1,1) not null,
	Name varchar(100) not null,
	Email varchar(100) not null,
	PhoneNumber varchar(20) not null,
	MessageText varchar(max) not null,
	SubmittedAt datetime Default(Getdate())
)