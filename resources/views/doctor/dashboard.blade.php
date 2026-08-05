@extends('layouts.dashboard')

@section('title', 'Doctor Dashboard - MediConnect')

@section('content')
<style>
    .stat-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.3s ease; }
    .stat-card:hover { border-color: var(--accent-blue); box-shadow: 0 4px 12px rgba(0, 136, 204, 0.1); }
    .stat-card i { font-size: 1.2rem; color: var(--primary-blue); margin-bottom: 10px; display: block; }
    .stat-card .stat-number { font-size: 1.8rem; font-weight: 700; color: #1a202c; line-height: 1; margin-bottom: 5px; }
    .stat-card .stat-label { font-size: 0.9rem; color: #64748b; font-weight: 500; }

    .appointment-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px 20px; display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 15px; }
    .appointment-card .patient-avatar { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; margin-right: 15px; }
    .appointment-info h6 { margin: 0 0 5px 0; font-weight: 600; color: #2d3748; }
    .appointment-info p { margin: 0; font-size: 0.85rem; color: #718096; }
    
    .status-badge { font-size: 0.75rem; padding: 4px 8px; border-radius: 4px; font-weight: 500; }
    .status-cancelled { background-color: #fed7d7; color: #c53030; }
    .status-booked { background-color: #c6f6d5; color: #22543d; }
    .status-available { background-color: #e2e8f0; color: #4a5568; }
    .status-completed { background-color: #bee3f8; color: #2b6cb0; }

    /* Thanh cuộn tùy chỉnh cho khung danh sách lịch hẹn */
    .appointment-scroll-container {
        max-height: 450px;
        overflow-y: auto;
        padding-right: 5px;
    }
    .appointment-scroll-container::-webkit-scrollbar {
        width: 6px;
    }
    .appointment-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .appointment-scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .appointment-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<h2 class="font-weight-bold mb-4" style="color: var(--primary-blue);">
    Welcome back, {{ $doctor->DoctorName ?? 'Doctor' }}!
</h2>

<!-- Hàng 3 thẻ thống kê động từ Database -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <i class="far fa-calendar-check"></i>
            <div class="stat-number">{{ $totalAppointments }}</div>
            <div class="stat-label">Appointments</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <i class="far fa-user"></i>
            <div class="stat-number">{{ $totalPatients }}</div>
            <div class="stat-label">Patients</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <i class="far fa-clock"></i>
            <div class="stat-number">{{ $availableSlots }}</div>
            <div class="stat-label">Available Slots</div>
        </div>
    </div>
</div>

<p class="text-muted mb-4">Stay on top of your schedule, patient updates, and availability—all from one dashboard.</p>

<h4 class="font-weight-bold mb-3" style="color: var(--primary-blue);">Upcoming Appointments</h4>

<!-- Khung chứa danh sách lịch hẹn (Có thanh cuộn chống tràn layout khi dữ liệu quá nhiều) -->
<div class="appointment-scroll-container">
    @forelse($upcomingAppointments as $item)
        <div class="appointment-card">
            <img src="{{ asset('Novena/images/patient-avatar.png') }}" alt="Patient" class="patient-avatar">
            
            <div class="appointment-info">
                <!-- Tên bệnh nhân hoặc hiển thị slot trống -->
                <h6>{{ $item->PatientName ?? 'No Patient (Available Slot)' }}</h6>
                
                <p>Status: 
                    <span class="status-badge 
                        @if($item->Status == 'Canceled') status-cancelled 
                        @elseif($item->Status == 'Booked') status-booked 
                        @elseif($item->Status == 'Completed') status-completed 
                        @else status-available @endif">
                        {{ $item->Status }}
                    </span>
                </p>
                
                <p class="mt-1">
                    <i class="far fa-calendar-alt mr-1"></i> {{ $item->AvailableDate }} | 
                    <i class="far fa-clock ml-2 mr-1"></i> {{ \Carbon\Carbon::parse($item->StartTime)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->EndTime)->format('H:i') }}
                </p>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Không có lịch hẹn nào trong hệ thống.</div>
    @endforelse
</div>

@endsection