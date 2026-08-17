@extends('doctor.layouts.dashboard')

@section('title', 'MediConnect - Doctor Appointments')

@section('content')

<style>
    .appointments-page {
        color: var(--doctor-text);
    }

    .page-title {
        color: var(--accent-blue);
        font-weight: 700;
    }

    .page-subtitle {
        color: var(--doctor-muted);
        margin-bottom: 25px;
    }

    .filter-card {
        background: var(--doctor-card);
        border: 1px solid var(--doctor-border);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .filter-label {
        color: var(--doctor-muted);
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        background: var(--doctor-bg);
        border: 1px solid var(--doctor-border);
        color: var(--doctor-text);
        border-radius: 6px;
        padding: 9px 12px;
        outline: none;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: var(--accent-blue);
    }

    .filter-btn {
        background: var(--accent-blue);
        border: none;
        color: #ffffff;
        border-radius: 6px;
        padding: 9px 18px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
    }

    .filter-btn:hover {
        opacity: 0.9;
    }

    .reset-btn {
        display: block;
        text-align: center;
        margin-top: 8px;
        color: var(--doctor-muted);
        text-decoration: none;
        font-size: 0.85rem;
    }

    .reset-btn:hover {
        color: var(--accent-blue);
    }

    .view-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }

    .view-tab {
        padding: 8px 18px;
        border-radius: 6px;
        border: 1px solid var(--doctor-border);
        background: var(--doctor-card);
        color: var(--doctor-muted);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .view-tab:hover {
        color: var(--accent-blue);
        border-color: var(--accent-blue);
    }

    .view-tab.active {
        background: var(--accent-blue);
        border-color: var(--accent-blue);
        color: #ffffff;
    }

    .appointment-section {
        background: var(--doctor-card);
        border: 1px solid var(--doctor-border);
        border-radius: 8px;
        padding: 20px;
    }

    .section-title {
        color: var(--accent-blue);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .appointment-item {
        background: var(--doctor-bg);
        border: 1px solid var(--doctor-border);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .appointment-item:last-child {
        margin-bottom: 0;
    }

    .patient-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: var(--doctor-avatar-bg);
        border: 1px solid var(--doctor-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent-blue);
        flex-shrink: 0;
        overflow: hidden;
    }

    .patient-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .patient-info {
        flex: 1;
        min-width: 0;
    }

    .patient-name {
        color: var(--doctor-text);
        font-weight: 700;
        margin-bottom: 5px;
    }

    .patient-email {
        color: var(--doctor-muted);
        font-size: 0.85rem;
        margin-bottom: 5px;
    }

    .appointment-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        color: var(--doctor-muted);
        font-size: 0.85rem;
    }

    .appointment-meta i {
        color: var(--accent-blue);
        margin-right: 4px;
    }

    .appointment-status {
        min-width: 180px;
        text-align: right;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 5px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-pending {
        background: #4a3918;
        color: #f6c85f;
    }

    .status-confirmed {
        background: #123d36;
        color: #5ee0b5;
    }

    .status-cancelled {
        background: #4a2028;
        color: #ff7b8a;
    }

    .status-completed {
        background: #193a5c;
        color: #68b8ff;
    }

    .status-default {
        background: var(--doctor-status-bg);
        color: var(--doctor-muted);
    }

    .appointment-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 7px;
        margin-top: 8px;
    }

    .appointment-action-btn {
        border: none;
        border-radius: 5px;
        padding: 6px 10px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .appointment-action-btn:hover {
        opacity: 0.9;
        text-decoration: none;
    }

    .btn-confirm {
        background: #123d36;
        color: #5ee0b5;
    }

    .btn-cancel {
        background: #4a2028;
        color: #ff7b8a;
    }

    .btn-complete {
        background: #193a5c;
        color: #68b8ff;
    }

    .cancel-form {
        margin-top: 10px;
        padding: 10px;
        background: var(--doctor-card);
        border: 1px solid var(--doctor-border);
        border-radius: 6px;
        text-align: left;
    }

    .cancel-form input {
        width: 100%;
        background: var(--doctor-bg);
        border: 1px solid var(--doctor-border);
        color: var(--doctor-text);
        border-radius: 5px;
        padding: 7px 9px;
        font-size: 0.8rem;
        outline: none;
        margin-bottom: 7px;
    }

    .cancel-form input:focus {
        border-color: var(--accent-blue);
    }

    .cancel-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 6px;
    }

    .cancel-submit-btn,
    .cancel-close-btn {
        border: none;
        border-radius: 5px;
        padding: 6px 10px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
    }

    .cancel-submit-btn {
        background: #4a2028;
        color: #ff7b8a;
    }

    .cancel-close-btn {
        background: var(--doctor-status-bg);
        color: var(--doctor-muted);
    }

    .cancellation-reason {
        margin-top: 8px;
        padding: 7px 9px;
        border-left: 3px solid #ff7b8a;
        background: rgba(255, 123, 138, 0.08);
        color: var(--doctor-muted);
        font-size: 0.8rem;
        text-align: left;
    }

    .cancellation-reason strong {
        color: #ff7b8a;
    }

    .empty-state {
        text-align: center;
        padding: 45px 20px;
        color: var(--doctor-muted);
    }

    .empty-state i {
        color: var(--accent-blue);
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .status-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .summary-item {
        background: var(--doctor-bg);
        border: 1px solid var(--doctor-border);
        border-radius: 6px;
        padding: 8px 12px;
        color: var(--doctor-muted);
        font-size: 0.8rem;
    }

    .summary-item strong {
        color: var(--doctor-text);
        margin-left: 4px;
    }

    .alert-message {
        border-radius: 6px;
        padding: 10px 14px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .alert-success-message {
        background: #123d36;
        color: #5ee0b5;
        border: 1px solid #246044;
    }

    .alert-error-message {
        background: #4a2028;
        color: #ff7b8a;
        border: 1px solid #71323b;
    }

    @media (max-width: 768px) {
        .appointment-item {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .appointment-status {
            width: 100%;
            min-width: auto;
            text-align: left;
            margin-left: 67px;
        }

        .appointment-actions {
            justify-content: flex-start;
        }

        .view-tabs {
            flex-wrap: wrap;
        }
    }
</style>

<div class="appointments-page">

    <h2 class="page-title">
        Appointments
    </h2>

    <div class="page-subtitle">
        View your appointments and manage booked patients.
    </div>

    @if(session('success'))
        <div class="alert-message alert-success-message">
            <i class="fas fa-check-circle mr-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-message alert-error-message">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-message alert-error-message">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="filter-card">

        <form
            method="GET"
            action="{{ route('doctor.appointments') }}"
        >

            <div class="row">

                <div class="col-md-3 mb-3">

                    <label class="filter-label">
                        View
                    </label>

                    <select
                        name="view"
                        class="filter-select"
                    >
                        <option
                            value="day"
                            {{ $view === 'day' ? 'selected' : '' }}
                        >
                            Day
                        </option>

                        <option
                            value="week"
                            {{ $view === 'week' ? 'selected' : '' }}
                        >
                            Week
                        </option>

                        <option
                            value="month"
                            {{ $view === 'month' ? 'selected' : '' }}
                        >
                            Month
                        </option>
                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label class="filter-label">
                        Date
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="{{ $date }}"
                        class="filter-input"
                    >

                </div>

                <div class="col-md-3 mb-3">

                    <label class="filter-label">
                        Patient
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search patient..."
                        class="filter-input"
                    >

                </div>

                <div class="col-md-2 mb-3">

                    <label class="filter-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="filter-select"
                    >

                        <option
                            value="All"
                            {{ $status === 'All' ? 'selected' : '' }}
                        >
                            All
                        </option>

                        <option
                            value="Pending"
                            {{ $status === 'Pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="Confirmed"
                            {{ $status === 'Confirmed' ? 'selected' : '' }}
                        >
                            Confirmed
                        </option>

                        <option
                            value="Completed"
                            {{ $status === 'Completed' ? 'selected' : '' }}
                        >
                            Completed
                        </option>

                        <option
                            value="Cancelled"
                            {{ $status === 'Cancelled' ? 'selected' : '' }}
                        >
                            Cancelled
                        </option>

                    </select>

                </div>

                <div class="col-md-1 mb-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="filter-btn"
                    >
                        <i class="fas fa-search"></i>
                    </button>

                </div>

            </div>

            <a
                href="{{ route('doctor.appointments') }}"
                class="reset-btn"
            >
                Reset filters
            </a>

        </form>

    </div>

    <div class="view-tabs">

        <a
            href="{{ route('doctor.appointments', [
                'view' => 'day',
                'date' => $date,
                'status' => $status,
                'search' => $search
            ]) }}"
            class="view-tab {{ $view === 'day' ? 'active' : '' }}"
        >
            <i class="far fa-calendar-day mr-1"></i>
            Day
        </a>

        <a
            href="{{ route('doctor.appointments', [
                'view' => 'week',
                'date' => $date,
                'status' => $status,
                'search' => $search
            ]) }}"
            class="view-tab {{ $view === 'week' ? 'active' : '' }}"
        >
            <i class="far fa-calendar-week mr-1"></i>
            Week
        </a>

        <a
            href="{{ route('doctor.appointments', [
                'view' => 'month',
                'date' => $date,
                'status' => $status,
                'search' => $search
            ]) }}"
            class="view-tab {{ $view === 'month' ? 'active' : '' }}"
        >
            <i class="far fa-calendar-alt mr-1"></i>
            Month
        </a>

    </div>

    <div class="status-summary">

        <div class="summary-item">
            All:
            <strong>
                {{ $statusCounts['All'] }}
            </strong>
        </div>

        <div class="summary-item">
            Pending:
            <strong>
                {{ $statusCounts['Pending'] }}
            </strong>
        </div>

        <div class="summary-item">
            Confirmed:
            <strong>
                {{ $statusCounts['Confirmed'] }}
            </strong>
        </div>

        <div class="summary-item">
            Completed:
            <strong>
                {{ $statusCounts['Completed'] }}
            </strong>
        </div>

        <div class="summary-item">
            Cancelled:
            <strong>
                {{ $statusCounts['Cancelled'] }}
            </strong>
        </div>

    </div>

    <div class="appointment-section">

        <h4 class="section-title">
            <i class="far fa-calendar-check mr-2"></i>
            Patients who booked
        </h4>

        @if($appointments->count())

            @foreach($appointments as $appointment)

                @php
                    $patient = $appointment->accountUser;

                    $statusValue = strtolower(
                        $appointment->Status ?? 'unknown'
                    );

                    $statusClass = match ($statusValue) {
                        'pending' =>
                            'status-pending',

                        'confirmed',
                        'approved' =>
                            'status-confirmed',

                        'completed' =>
                            'status-completed',

                        'cancelled',
                        'cancelled_by_doctor',
                        'cancelled_by_patient',
                        'rejected' =>
                            'status-cancelled',

                        default =>
                            'status-default',
                    };
                @endphp

                <div class="appointment-item">

                    <div class="patient-avatar">

                        @if(
                            $patient &&
                            !empty($patient->AvatarUrl)
                        )

                            <img
                                src="{{ asset($patient->AvatarUrl) }}"
                                alt="{{ $patient->FullName }}"
                                onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';"
                            >

                            <i
                                class="fas fa-user"
                                style="display:none;"
                            ></i>

                        @else

                            <i class="fas fa-user"></i>

                        @endif

                    </div>

                    <div class="patient-info">

                        <div class="patient-name">
                            {{ $patient->FullName ?? 'Unknown Patient' }}
                        </div>

                        @if(
                            $patient &&
                            !empty($patient->Email)
                        )

                            <div class="patient-email">
                                {{ $patient->Email }}
                            </div>

                        @endif

                        <div class="appointment-meta">

                            <span>
                                <i class="far fa-calendar"></i>

                                {{
                                    \Carbon\Carbon::parse(
                                        $appointment->AppointmentDate
                                    )->format('d/m/Y')
                                }}
                            </span>

                            <span>
                                <i class="far fa-clock"></i>

                                {{
                                    \Carbon\Carbon::parse(
                                        $appointment->StartTime
                                    )->format('H:i')
                                }}

                                -

                                {{
                                    \Carbon\Carbon::parse(
                                        $appointment->EndTime
                                    )->format('H:i')
                                }}
                            </span>

                            @if(!empty($appointment->Reason))

                                <span>
                                    <i class="far fa-comment"></i>
                                    {{ $appointment->Reason }}
                                </span>

                            @endif

                        </div>

                    </div>

                    <div class="appointment-status">

                        <span
                            class="status-badge {{ $statusClass }}"
                        >
                            {{ $appointment->Status ?? 'Unknown' }}
                        </span>

                        @if($statusValue === 'pending')

                            <div class="appointment-actions">

                                <form
                                    method="POST"
                                    action="{{ route('doctor.appointments.confirm', $appointment->AppointmentId) }}"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="appointment-action-btn btn-confirm"
                                    >
                                        <i class="fas fa-check"></i>
                                        Confirm
                                    </button>
                                </form>

                                <button
                                    type="button"
                                    class="appointment-action-btn btn-cancel"
                                    onclick="showCancelForm({{ $appointment->AppointmentId }})"
                                >
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </button>

                            </div>

                            <form
                                method="POST"
                                action="{{ route('doctor.appointments.cancel', $appointment->AppointmentId) }}"
                                class="cancel-form"
                                id="cancel-form-{{ $appointment->AppointmentId }}"
                                style="display:none;"
                            >
                                @csrf

                                <input
                                    type="text"
                                    name="CancellationReason"
                                    placeholder="Enter cancellation reason..."
                                    maxlength="255"
                                    required
                                >

                                <div class="cancel-form-actions">

                                    <button
                                        type="button"
                                        class="cancel-close-btn"
                                        onclick="hideCancelForm({{ $appointment->AppointmentId }})"
                                    >
                                        Close
                                    </button>

                                    <button
                                        type="submit"
                                        class="cancel-submit-btn"
                                    >
                                        Confirm Cancel
                                    </button>

                                </div>

                            </form>

                        @elseif($statusValue === 'confirmed')

                            <div class="appointment-actions">

                                <form
                                    method="POST"
                                    action="{{ route('doctor.appointments.complete', $appointment->AppointmentId) }}"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="appointment-action-btn btn-complete"
                                    >
                                        <i class="fas fa-check-double"></i>
                                        Mark as Completed
                                    </button>

                                </form>

                            </div>

                        @elseif(
                            $statusValue === 'cancelled' ||
                            $statusValue === 'cancelled_by_doctor' ||
                            $statusValue === 'cancelled_by_patient' ||
                            $statusValue === 'rejected'
                        )

                            @if(!empty($appointment->CancellationReason))

                                <div class="cancellation-reason">
                                    <strong>Cancellation reason:</strong>
                                    {{ $appointment->CancellationReason }}
                                </div>

                            @endif

                        @endif

                    </div>

                </div>

            @endforeach

        @else

            <div class="empty-state">

                <i class="far fa-calendar-times d-block"></i>

                <div>
                    No appointments found.
                </div>

            </div>

        @endif

    </div>

</div>

<script>
    function showCancelForm(id) {
        const form = document.getElementById('cancel-form-' + id);

        if (form) {
            form.style.display = 'block';
        }
    }

    function hideCancelForm(id) {
        const form = document.getElementById('cancel-form-' + id);

        if (form) {
            form.style.display = 'none';

            const input = form.querySelector('input[name="CancellationReason"]');

            if (input) {
                input.value = '';
            }
        }
    }
</script>

@endsection