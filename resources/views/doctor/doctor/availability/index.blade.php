@extends('doctor.layouts.dashboard')

@section('title', 'MediConnect - Availability')

@section('content')

<style>
    .doctor-availability {
        --card-bg: #ffffff;
        --input-bg: #ffffff;
        --text-color: #172b50;
        --muted-color: #6c7a89;
        --border-color: #d8e3ef;
        --primary-color: #0088cc;
        --primary-dark: #223b6b;
        --hover-bg: #f4f9fc;
        --available-bg: rgba(0, 136, 204, .07);

        width: 100%;
        color: var(--text-color);
        box-sizing: border-box;
    }

    @media (prefers-color-scheme: dark) {
        .doctor-availability {
            --card-bg: #16263d;
            --input-bg: #101a29;
            --text-color: #f2f6fb;
            --muted-color: #aebdd0;
            --border-color: #30445f;
            --primary-color: #3da9e0;
            --primary-dark: #223b6b;
            --hover-bg: #1b304c;
            --available-bg: rgba(61, 169, 224, .12);
        }
    }

    .availability-header {
        margin-bottom: 28px;
    }

    .availability-header h2 {
        margin: 0;
        color: var(--primary-color);
        font-size: 32px;
        font-weight: 700;
    }

    .availability-header p {
        margin: 5px 0 0;
        color: var(--muted-color);
    }

    .availability-card {
        width: 100%;
        padding: 32px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .08);
        box-sizing: border-box;
    }

    .availability-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .availability-card-header i {
        color: var(--primary-color);
        font-size: 20px;
    }

    .availability-card-header h3 {
        margin: 0;
        color: var(--text-color);
        font-size: 22px;
        font-weight: 700;
    }

    .weekly-calendar {
        width: 100%;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
    }

    .week-header {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        background: var(--hover-bg);
        border-bottom: 1px solid var(--border-color);
    }

    .week-day {
        padding: 16px 8px;
        text-align: center;
        border-right: 1px solid var(--border-color);
    }

    .week-day:last-child {
        border-right: none;
    }

    .week-day-name {
        display: block;
        color: var(--text-color);
        font-size: 14px;
        font-weight: 700;
    }

    .week-day-date {
        display: block;
        margin-top: 4px;
        color: var(--muted-color);
        font-size: 12px;
    }

    .week-body {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
    }

    .day-column {
        min-width: 0;
        padding: 10px;
        border-right: 1px solid var(--border-color);
    }

    .day-column:last-child {
        border-right: none;
    }

    .shift-card {
        position: relative;
        margin-bottom: 12px;
        padding: 14px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        cursor: pointer;
        transition: all .2s ease;
    }

    .shift-card:last-child {
        margin-bottom: 0;
    }

    .shift-card:hover {
        border-color: var(--primary-color);
        background: var(--hover-bg);
        transform: translateY(-1px);
    }

    .shift-card.active {
        border-color: var(--primary-color);
        background: var(--available-bg);
    }

    .shift-card.off {
        border-color: var(--border-color);
    }

    .shift-card.selecting {
        border-color: var(--primary-color);
    }

    .shift-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        margin-bottom: 9px;
        border-radius: 50%;
        background: rgba(0, 136, 204, .1);
        color: var(--primary-color);
        font-size: 14px;
    }

    .shift-title {
        margin-bottom: 4px;
        color: var(--text-color);
        font-size: 14px;
        font-weight: 700;
    }

    .shift-time {
        color: var(--muted-color);
        font-size: 12px;
    }

    .shift-status {
        margin-top: 9px;
        font-size: 12px;
        font-weight: 600;
    }

    .shift-status.available {
        color: #16a34a;
    }

    .shift-status.off {
        color: var(--muted-color);
    }

    .shift-status.pending {
        color: #d97706;
    }

    .shift-options {
        display: none;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid var(--border-color);
    }

    .shift-card.selecting .shift-options {
        display: block;
    }

    .shift-option {
        display: flex;
        align-items: center;
        width: 100%;
        margin-bottom: 6px;
        padding: 7px 8px;
        border: 1px solid transparent;
        border-radius: 5px;
        background: transparent;
        color: var(--text-color);
        font-size: 12px;
        cursor: pointer;
        text-align: left;
        transition: .2s;
    }

    .shift-option:last-child {
        margin-bottom: 0;
    }

    .shift-option:hover {
        border-color: var(--primary-color);
        background: var(--hover-bg);
    }

    .shift-option i {
        width: 18px;
        margin-right: 6px;
        color: var(--primary-color);
    }

    .shift-option.day-off i {
        color: var(--muted-color);
    }

    .reason-box {
        display: none;
        margin-top: 10px;
    }

    .shift-card.show-reason .reason-box {
        display: block;
    }

    .reason-label {
        display: block;
        margin-bottom: 5px;
        color: var(--text-color);
        font-size: 11px;
        font-weight: 600;
    }

    .reason-input {
        width: 100%;
        min-height: 60px;
        padding: 8px;
        resize: vertical;
        background: var(--input-bg);
        color: var(--text-color);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        font-size: 12px;
        box-sizing: border-box;
    }

    .reason-input:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .reason-input::placeholder {
        color: var(--muted-color);
    }

    .availability-actions {
        display: flex;
        justify-content: flex-end;
        padding-top: 25px;
    }

    .btn-save {
        min-width: 150px;
        height: 50px;
        border-radius: 6px;
        background: var(--primary-color);
        border: 1px solid var(--primary-color);
        color: #fff;
        font-weight: 600;
    }

    .btn-save:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        color: #fff;
    }

    @media (max-width: 1100px) {
        .availability-card {
            padding: 20px;
        }

        .week-day {
            padding: 13px 5px;
        }

        .week-day-name {
            font-size: 13px;
        }

        .day-column {
            padding: 7px;
        }

        .shift-card {
            padding: 11px 9px;
        }
    }

    @media (max-width: 767px) {
        .availability-header h2 {
            font-size: 26px;
        }

        .availability-header p {
            font-size: 14px;
        }

        .availability-card {
            padding: 15px;
        }

        .weekly-calendar {
            overflow-x: auto;
        }

        .week-header,
        .week-body {
            min-width: 700px;
        }

        .availability-actions {
            justify-content: stretch;
        }

        .btn-save {
            width: 100%;
        }
    }
</style>

<div class="doctor-availability">

    <div class="availability-header">

        <h2>
            Doctor Availability
        </h2>

        <p>
            View and manage your weekly working schedule.
        </p>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    @php

        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];

        $startOfWeek = $startOfWeek->copy();

        $scheduleMap = $schedules->keyBy(function ($schedule) {

            $date = \Carbon\Carbon::parse(
                $schedule->WorkDate
            )->format('Y-m-d');

            $time = \Carbon\Carbon::parse(
                $schedule->StartTime
            )->format('H:i');

            return $date . '_' . $time;

        });

    @endphp

    <div class="availability-card">

        <div class="availability-card-header">

            <i class="fas fa-calendar-alt"></i>

            <h3>
                Weekly Schedule
            </h3>

        </div>

        <form
            id="availabilityForm"
            action="{{ route('doctor.availability.save') }}"
            method="POST"
        >

            @csrf

            <div class="weekly-calendar">

                <div class="week-header">

                    @foreach($days as $index => $day)

                        @php

                            $date = $startOfWeek
                                ->copy()
                                ->addDays($index);

                        @endphp

                        <div class="week-day">

                            <span class="week-day-name">
                                {{ $day }}
                            </span>

                            <span class="week-day-date">
                                {{ $date->format('d/m/Y') }}
                            </span>

                        </div>

                    @endforeach

                </div>

                <div class="week-body">

                    @foreach($days as $index => $day)

                        @php

                            $date = $startOfWeek
                                ->copy()
                                ->addDays($index);

                            $morning = $scheduleMap->get(
                                $date->format('Y-m-d') . '_08:00'
                            );

                            $afternoon = $scheduleMap->get(
                                $date->format('Y-m-d') . '_13:00'
                            );

                            $morningStatus =
                                $morning
                                    ? $morning->Status
                                    : null;

                            $afternoonStatus =
                                $afternoon
                                    ? $afternoon->Status
                                    : null;

                            $morningNote =
                                $morning
                                    ? $morning->Note
                                    : '';

                            $afternoonNote =
                                $afternoon
                                    ? $afternoon->Note
                                    : '';

                            $morningIndex =
                                $index * 2;

                            $afternoonIndex =
                                ($index * 2) + 1;

                        @endphp

                        <div class="day-column">

                            <div
                                class="shift-card
                                {{ $morningStatus === 'Available' ? 'active' : '' }}
                                {{ $morningStatus === 'Off' ? 'off show-reason' : '' }}"
                                data-status="{{ $morningStatus ?? '' }}"
                                onclick="toggleShift(this)"
                            >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $morningIndex }}][WorkDate]"
                                    value="{{ $date->toDateString() }}"
                                >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $morningIndex }}][StartTime]"
                                    value="08:00"
                                >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $morningIndex }}][EndTime]"
                                    value="12:00"
                                >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $morningIndex }}][Status]"
                                    value="{{ $morningStatus ?? '' }}"
                                    class="status-input"
                                >

                                <div class="shift-icon">
                                    <i class="fas fa-sun"></i>
                                </div>

                                <div class="shift-title">
                                    Morning
                                </div>

                                <div class="shift-time">
                                    08:00 - 12:00
                                </div>

                                <div
                                    class="shift-status
                                    {{ $morningStatus === 'Available' ? 'available' : '' }}
                                    {{ $morningStatus === 'Off' ? 'off' : '' }}
                                    {{ !$morningStatus ? 'pending' : '' }}"
                                >

                                    @if($morningStatus === 'Available')
                                        Available
                                    @elseif($morningStatus === 'Off')
                                        Day Off
                                    @else
                                        Select status
                                    @endif

                                </div>

                                <div class="shift-options">

                                    <button
                                        type="button"
                                        class="shift-option"
                                        onclick="setShiftStatus(
                                            event,
                                            this.closest('.shift-card'),
                                            'Available'
                                        )"
                                    >
                                        <i class="fas fa-check"></i>
                                        Available
                                    </button>

                                    <button
                                        type="button"
                                        class="shift-option day-off"
                                        onclick="setShiftStatus(
                                            event,
                                            this.closest('.shift-card'),
                                            'Off'
                                        )"
                                    >
                                        <i class="fas fa-ban"></i>
                                        Day Off
                                    </button>

                                </div>

                                <div class="reason-box">

                                    <label class="reason-label">
                                        Reason for day off
                                    </label>

                                    <textarea
                                        name="schedules[{{ $morningIndex }}][Note]"
                                        class="reason-input"
                                        placeholder="Enter reason..."
                                        onclick="event.stopPropagation()"
                                    >{{ old("schedules.$morningIndex.Note", $morningNote) }}</textarea>

                                </div>

                            </div>

                            <div
                                class="shift-card
                                {{ $afternoonStatus === 'Available' ? 'active' : '' }}
                                {{ $afternoonStatus === 'Off' ? 'off show-reason' : '' }}"
                                data-status="{{ $afternoonStatus ?? '' }}"
                                onclick="toggleShift(this)"
                            >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $afternoonIndex }}][WorkDate]"
                                    value="{{ $date->toDateString() }}"
                                >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $afternoonIndex }}][StartTime]"
                                    value="13:00"
                                >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $afternoonIndex }}][EndTime]"
                                    value="17:00"
                                >

                                <input
                                    type="hidden"
                                    name="schedules[{{ $afternoonIndex }}][Status]"
                                    value="{{ $afternoonStatus ?? '' }}"
                                    class="status-input"
                                >

                                <div class="shift-icon">
                                    <i class="fas fa-cloud-sun"></i>
                                </div>

                                <div class="shift-title">
                                    Afternoon
                                </div>

                                <div class="shift-time">
                                    13:00 - 17:00
                                </div>

                                <div
                                    class="shift-status
                                    {{ $afternoonStatus === 'Available' ? 'available' : '' }}
                                    {{ $afternoonStatus === 'Off' ? 'off' : '' }}
                                    {{ !$afternoonStatus ? 'pending' : '' }}"
                                >

                                    @if($afternoonStatus === 'Available')
                                        Available
                                    @elseif($afternoonStatus === 'Off')
                                        Day Off
                                    @else
                                        Select status
                                    @endif

                                </div>

                                <div class="shift-options">

                                    <button
                                        type="button"
                                        class="shift-option"
                                        onclick="setShiftStatus(
                                            event,
                                            this.closest('.shift-card'),
                                            'Available'
                                        )"
                                    >
                                        <i class="fas fa-check"></i>
                                        Available
                                    </button>

                                    <button
                                        type="button"
                                        class="shift-option day-off"
                                        onclick="setShiftStatus(
                                            event,
                                            this.closest('.shift-card'),
                                            'Off'
                                        )"
                                    >
                                        <i class="fas fa-ban"></i>
                                        Day Off
                                    </button>

                                </div>

                                <div class="reason-box">

                                    <label class="reason-label">
                                        Reason for day off
                                    </label>

                                    <textarea
                                        name="schedules[{{ $afternoonIndex }}][Note]"
                                        class="reason-input"
                                        placeholder="Enter reason..."
                                        onclick="event.stopPropagation()"
                                    >{{ old("schedules.$afternoonIndex.Note", $afternoonNote) }}</textarea>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            <div class="availability-actions">

                <button
                    type="submit"
                    class="btn btn-save"
                >
                    <i class="fas fa-save mr-2"></i>
                    Save Schedule
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function toggleShift(element)
    {
        document
            .querySelectorAll('.shift-card.selecting')
            .forEach(function (card) {

                if (card !== element) {
                    card.classList.remove('selecting');
                }

            });

        element.classList.toggle('selecting');
    }

    function setShiftStatus(event, element, status)
    {
        event.stopPropagation();

        const statusInput =
            element.querySelector('.status-input');

        const statusElement =
            element.querySelector('.shift-status');

        const reasonInput =
            element.querySelector('.reason-input');

        element.dataset.status = status;

        statusInput.value = status;

        if (status === 'Available') {

            element.classList.add('active');
            element.classList.remove('off');
            element.classList.remove('show-reason');

            statusElement.classList.remove('off');
            statusElement.classList.remove('pending');
            statusElement.classList.add('available');

            statusElement.textContent = 'Available';

            if (reasonInput) {
                reasonInput.value = '';
            }

        } else {

            element.classList.remove('active');
            element.classList.add('off');
            element.classList.add('show-reason');

            statusElement.classList.remove('available');
            statusElement.classList.remove('pending');
            statusElement.classList.add('off');

            statusElement.textContent = 'Day Off';
        }

        element.classList.remove('selecting');
    }

    document
        .getElementById('availabilityForm')
        .addEventListener('submit', function (event) {

            const shifts =
                document.querySelectorAll(
                    '#availabilityForm .shift-card'
                );

            let valid = true;

            shifts.forEach(function (shift) {

                const status =
                    shift.querySelector(
                        '.status-input'
                    ).value;

                const reason =
                    shift.querySelector(
                        '.reason-input'
                    );

                shift.style.borderColor = '';

                if (!status) {

                    valid = false;

                    shift.style.borderColor =
                        '#dc3545';
                }

                if (
                    status === 'Off' &&
                    (
                        !reason ||
                        reason.value.trim() === ''
                    )
                ) {

                    valid = false;

                    shift.classList.add(
                        'show-reason'
                    );

                    shift.style.borderColor =
                        '#dc3545';
                }

            });

            if (!valid) {
                event.preventDefault();
                return;
            }
        });
</script>

@endsection