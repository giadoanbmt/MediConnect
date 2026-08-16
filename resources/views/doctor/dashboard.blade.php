@extends('doctor.layouts.dashboard')

@section('title', 'MediConnect - Doctor Dashboard')

@section('content')

<style>
    .dashboard-page {
        color: var(--doctor-text);
    }

    .dashboard-title {
        color: var(--accent-blue);
        font-weight: 700;
    }

    .today-label {
        color: var(--doctor-muted);
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .today-label i {
        color: var(--accent-blue);
    }

    .stat-card {
        background: var(--doctor-card);
        border: 1px solid var(--doctor-border);
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        border-color: var(--accent-blue);
        box-shadow: 0 4px 12px rgba(0, 136, 204, 0.15);
    }

    .stat-card i {
        font-size: 1.2rem;
        color: var(--accent-blue);
        margin-bottom: 10px;
        display: block;
    }

    .stat-card .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--doctor-text);
        line-height: 1;
        margin-bottom: 5px;
    }

    .stat-card .stat-label {
        font-size: 0.9rem;
        color: var(--doctor-muted);
        font-weight: 500;
    }

    .section-title {
        color: var(--accent-blue);
        font-weight: 700;
    }

    .appointment-card {
        background: var(--doctor-card);
        border: 1px solid var(--doctor-border);
        border-radius: 8px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .appointment-card:hover {
        border-color: var(--accent-blue);
        box-shadow: 0 4px 12px rgba(0, 136, 204, 0.15);
    }

    .patient-avatar {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 18px;
        flex-shrink: 0;
    }

    .patient-avatar-default {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: var(--doctor-avatar-bg);
        color: var(--accent-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 18px;
        flex-shrink: 0;
        font-size: 1.2rem;
        border: 1px solid var(--doctor-border);
    }

    .appointment-info {
        flex: 1;
    }

    .appointment-info h6 {
        margin: 0 0 6px 0;
        font-weight: 600;
        color: var(--doctor-text);
        font-size: 1rem;
    }

    .appointment-info p {
        margin: 0 0 4px 0;
        font-size: 0.85rem;
        color: var(--doctor-muted);
    }

    .appointment-time {
        color: var(--accent-blue) !important;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 4px;
        font-weight: 500;
    }

    .status-confirmed {
        background: #d1fae5;
        color: #047857;
    }

    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .status-cancelled {
        background: #fed7d7;
        color: #c53030;
    }

    .status-completed {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-default {
        background: var(--doctor-status-bg);
        color: var(--doctor-muted);
    }

    .appointment-empty {
        background: var(--doctor-card);
        border: 1px solid var(--doctor-border);
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        color: var(--doctor-muted);
    }

    .appointment-empty i {
        color: var(--accent-blue);
    }

    @media (prefers-color-scheme: dark) {
        .status-confirmed {
            background: #123d36;
            color: #5ee0b5;
        }

        .status-pending {
            background: #4a3918;
            color: #f6c85f;
        }

        .status-cancelled {
            background: #4a2028;
            color: #ff7b8a;
        }

        .status-completed {
            background: #193a5c;
            color: #68b8ff;
        }
    }
</style>

<div class="dashboard-page">

    <h2 class="font-weight-bold mb-2 dashboard-title">
        Dashboard
    </h2>

    <div class="today-label">
        <i class="far fa-calendar-alt mr-1"></i>
        Today's schedule
    </div>

    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="stat-card">

                <i class="far fa-calendar-check"></i>

                <div class="stat-number">
                    {{ $todayAppointments->count() }}
                </div>

                <div class="stat-label">
                    Today's Appointments
                </div>

            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">

                <i class="far fa-user"></i>

                <div class="stat-number">
                    {{ $todayPatients }}
                </div>

                <div class="stat-label">
                    Today's Patients
                </div>

            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card">

                <i class="far fa-clock"></i>

                <div class="stat-number">
                    {{ $availableSlots }}
                </div>

                <div class="stat-label">
                    Available Slots
                </div>

            </div>
        </div>

    </div>

    <h4 class="section-title mb-3">
        Today's Appointments
    </h4>

    @if($todayAppointments->count())

        @foreach($todayAppointments as $appointment)

            @php
                $patient = $appointment->accountUser;
                $status = strtolower($appointment->Status ?? 'unknown');

                $statusClass = match ($status) {
                    'confirmed' => 'status-confirmed',
                    'pending' => 'status-pending',
                    'cancelled',
                    'cancelled_by_doctor',
                    'cancelled_by_patient' => 'status-cancelled',
                    'completed' => 'status-completed',
                    default => 'status-default',
                };
            @endphp

            <div class="appointment-card">

                @if(
                    $patient &&
                    !empty($patient->AvatarUrl)
                )

                    <img
                        src="{{ asset($patient->AvatarUrl) }}"
                        alt="{{ $patient->FullName ?? 'Patient' }}"
                        class="patient-avatar"
                        onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';"
                    >

                    <div
                        class="patient-avatar-default"
                        style="display:none;"
                    >
                        <i class="fas fa-user"></i>
                    </div>

                @else

                    <div class="patient-avatar-default">
                        <i class="fas fa-user"></i>
                    </div>

                @endif

                <div class="appointment-info">

                    <h6>
                        {{ $patient->FullName ?? 'Unknown Patient' }}
                    </h6>

                    <p>
                        <i class="far fa-clock mr-1"></i>

                        <span class="appointment-time">
                            {{ \Carbon\Carbon::parse($appointment->StartTime)->format('H:i') }}
                        </span>
                    </p>

                    <p>
                        Status:

                        <span class="status-badge {{ $statusClass }}">
                            {{ $appointment->Status ?? 'Unknown' }}
                        </span>
                    </p>

                </div>

            </div>

        @endforeach

    @else

        <div class="appointment-empty">

            <i
                class="far fa-calendar-times mb-2"
                style="font-size: 1.5rem;"
            ></i>

            <div>
                No appointments scheduled for today.
            </div>

        </div>

    @endif

</div>

@endsection