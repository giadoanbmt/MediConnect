@extends('layouts.dashboard')

@section('title', 'Doctor Dashboard - MediConnect')

@section('content')
<!-- Custom CSS riêng cho trang Dashboard Bác sĩ -->
<style>
    /* Thẻ thống kê (Stat Cards) */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        border-color: var(--accent-blue);
        box-shadow: 0 4px 12px rgba(0, 136, 204, 0.1);
    }
    .stat-card i {
        font-size: 1.2rem;
        color: var(--primary-blue);
        margin-bottom: 10px;
        display: block;
    }
    .stat-card .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1;
        margin-bottom: 5px;
    }
    .stat-card .stat-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }

    /* Thanh lịch ngang (Weekly Calendar) */
    .calendar-week {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    .calendar-day {
        background: #718096; /* Màu xám mặc định */
        color: white;
        border-radius: 8px;
        padding: 10px 15px;
        text-align: center;
        min-width: 80px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .calendar-day:hover {
        background: #4a5568;
    }
    .calendar-day.active {
        background: var(--accent-blue); /* Màu xanh lam sáng khi được chọn */
        box-shadow: 0 4px 10px rgba(0, 136, 204, 0.3);
    }
    .calendar-day .day-name {
        font-size: 0.85rem;
        display: block;
        margin-bottom: 2px;
    }
    .calendar-day .day-date {
        font-size: 1rem;
        font-weight: bold;
    }

    /* Thẻ danh sách lịch hẹn (Appointment List) */
    .appointment-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        margin-bottom: 15px;
    }
    .appointment-card .patient-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }
    .appointment-info h6 {
        margin: 0 0 5px 0;
        font-weight: 600;
        color: #2d3748;
    }
    .appointment-info p {
        margin: 0;
        font-size: 0.85rem;
        color: #718096;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 500;
    }
    .status-cancelled {
        background-color: #fed7d7;
        color: #c53030;
    }
</style>

<!-- Tiêu đề trang -->
<h2 class="font-weight-bold mb-4" style="color: var(--primary-blue);">Dashboard</h2>

<!-- Hàng 3 thẻ thống kê -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <i class="far fa-calendar-check"></i>
            <div class="stat-number">3</div>
            <div class="stat-label">Appointments</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <i class="far fa-user"></i>
            <div class="stat-number">2</div>
            <div class="stat-label">Patients</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <i class="far fa-clock"></i>
            <div class="stat-number">1</div>
            <div class="stat-label">Available Slots</div>
        </div>
    </div>
</div>

<!-- Dòng chú thích -->
<p class="text-muted mb-4">Stay on top of your schedule, patient updates, and availability—all from one dashboard.</p>

<!-- Phần Lịch hẹn sắp tới -->
<h4 class="font-weight-bold mb-3" style="color: var(--primary-blue);">Upcoming Appointments</h4>

<!-- Bộ chọn lịch tuần -->
 
 <!-- inprogress~~ -->

<!-- Thẻ thông tin 1 lịch hẹn -->
<div class="appointment-card">
    <!-- Ảnh đại diện bệnh nhân (Có thể dùng ảnh mặc định) -->
    <img src="{{ asset('Novena/images/patient-avatar.png') }}" alt="Patient" class="patient-avatar">
    
    <div class="appointment-info">
        <h6>Nguyen Van A</h6>
        <p>Status: <span class="status-badge status-cancelled">cancelled_by_doctor</span></p>
        <p class="mt-1"><i class="far fa-clock mr-1"></i> 10:00</p>
    </div>
</div>

@endsection