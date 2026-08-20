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

    .week-navigation {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 20px;
    }

    .week-navigation-center {
        flex: 1;
        text-align: center;
        color: var(--text-color);
        font-size: 15px;
        font-weight: 700;
    }

    .week-navigation-center span {
        color: var(--muted-color);
        font-weight: 500;
    }

    .week-navigation-button {
        min-width: 120px;
        height: 40px;
        padding: 0 14px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: var(--card-bg);
        color: var(--text-color);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .week-navigation-button:hover {
        border-color: var(--primary-color);
        background: var(--hover-bg);
        color: var(--primary-color);
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
        transition: all .2s ease;
    }

    .shift-card:last-child {
        margin-bottom: 0;
    }

    .shift-card:hover {
        border-color: var(--primary-color);
        background: var(--hover-bg);
    }

    .shift-card.active {
        border-color: var(--primary-color);
        background: var(--available-bg);
    }

    .shift-card.off {
        border-color: var(--border-color);
    }

    .shift-card.past-week {
        cursor: default;
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
        margin-bottom: 8px;
        color: var(--text-color);
        font-size: 14px;
        font-weight: 700;
    }

    .shift-time-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .shift-time-item {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 6px 0;
        border-bottom: 1px solid var(--border-color);
        color: var(--muted-color);
        font-size: 12px;
    }

    .shift-time-item:last-child {
        border-bottom: none;
    }

    .shift-time-item i {
        color: var(--primary-color);
        font-size: 9px;
    }

    .shift-status {
        margin-top: 10px;
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
        margin-top: 10px;
        padding-top: 8px;
        border-top: 1px solid var(--border-color);
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

        .week-navigation {
            flex-wrap: wrap;
        }

        .week-navigation-center {
            order: -1;
            width: 100%;
            flex-basis: 100%;
        }

        .week-navigation-button {
            flex: 1;
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

        $morningSlots = [

            [
                'start' => '08:00',
                'end' => '09:00'
            ],

            [
                'start' => '09:30',
                'end' => '10:30'
            ],

            [
                'start' => '11:00',
                'end' => '12:00'
            ],

        ];

        $afternoonSlots = [

            [
                'start' => '13:00',
                'end' => '14:00'
            ],

            [
                'start' => '14:30',
                'end' => '15:30'
            ],

            [
                'start' => '16:00',
                'end' => '17:00'
            ],

        ];

        $days = [

            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'

        ];

        $startOfWeek =
            $startOfWeek->copy();

        $endOfWeek =
            $startOfWeek
                ->copy()
                ->endOfWeek();

        $currentWeek =
            now()
                ->startOfWeek()
                ->toDateString();

        $isPastWeek =
            $startOfWeek->toDateString()
            < $currentWeek;

        $previousWeek =
            $startOfWeek
                ->copy()
                ->subWeek()
                ->toDateString();

        $nextWeek =
            $startOfWeek
                ->copy()
                ->addWeek()
                ->toDateString();

        $scheduleMap =
            $schedules->keyBy(
                function ($schedule) {

                    $date =
                        \Carbon\Carbon::parse(
                            $schedule->WorkDate
                        )->format('Y-m-d');

                    $time =
                        \Carbon\Carbon::parse(
                            $schedule->StartTime
                        )->format('H:i');

                    return
                        $date . '_' . $time;

                }
            );

    @endphp

    <div class="availability-card">

        <div class="availability-card-header">

            <i class="fas fa-calendar-alt"></i>

            <h3>
                Weekly Schedule
            </h3>

        </div>

        <div class="week-navigation">

            <button
                type="button"
                class="week-navigation-button"
                onclick="changeWeek('{{ $previousWeek }}')"
            >

                <i class="fas fa-chevron-left mr-1"></i>

                Previous Week

            </button>

            <div class="week-navigation-center">

                {{ $startOfWeek->format('d/m/Y') }}

                -

                {{ $endOfWeek->format('d/m/Y') }}

                @if(
                    $startOfWeek->toDateString()
                    === $currentWeek
                )

                    <span>
                        (Current Week)
                    </span>

                @elseif($isPastWeek)

                    <span>
                        (Past Week)
                    </span>

                @else

                    <span>
                        (Future Week)
                    </span>

                @endif

            </div>

            <button
                type="button"
                class="week-navigation-button"
                onclick="changeWeek('{{ $nextWeek }}')"
            >

                Next Week

                <i class="fas fa-chevron-right ml-1"></i>

            </button>

        </div>

        <form
            id="availabilityForm"
            action="{{ route('doctor.availability.save') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="week"
                value="{{ $startOfWeek->toDateString() }}"
            >

            <div class="weekly-calendar">

                <div class="week-header">

                    @foreach($days as $index => $day)

                        @php

                            $date =
                                $startOfWeek
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

                            $date =
                                $startOfWeek
                                    ->copy()
                                    ->addDays($index);

                            $morningSchedules = [];

                            foreach(
                                $morningSlots
                                as $slotIndex => $slot
                            ) {

                                $key =
                                    $date->format('Y-m-d')
                                    . '_'
                                    . $slot['start'];

                                $morningSchedules[$slotIndex] =
                                    $scheduleMap->get($key);

                            }

                            $afternoonSchedules = [];

                            foreach(
                                $afternoonSlots
                                as $slotIndex => $slot
                            ) {

                                $key =
                                    $date->format('Y-m-d')
                                    . '_'
                                    . $slot['start'];

                                $afternoonSchedules[$slotIndex] =
                                    $scheduleMap->get($key);

                            }

                            $morningStatuses =
                                collect($morningSchedules)
                                    ->map(
                                        fn($schedule) =>
                                            $schedule?->Status
                                    );

                            $afternoonStatuses =
                                collect($afternoonSchedules)
                                    ->map(
                                        fn($schedule) =>
                                            $schedule?->Status
                                    );

                            $morningIsOff =
                                $morningStatuses->count() === 3
                                &&
                                $morningStatuses
                                    ->every(
                                        fn($status) =>
                                            $status === 'Off'
                                    );

                            $afternoonIsOff =
                                $afternoonStatuses->count() === 3
                                &&
                                $afternoonStatuses
                                    ->every(
                                        fn($status) =>
                                            $status === 'Off'
                                    );

                            $morningIsAvailable =
                                $morningStatuses
                                    ->contains('Available');

                            $afternoonIsAvailable =
                                $afternoonStatuses
                                    ->contains('Available');

                            $morningStatus =
                                $morningIsOff
                                    ? 'Off'
                                    : (
                                        $morningIsAvailable
                                            ? 'Available'
                                            : ''
                                    );

                            $afternoonStatus =
                                $afternoonIsOff
                                    ? 'Off'
                                    : (
                                        $afternoonIsAvailable
                                            ? 'Available'
                                            : ''
                                    );

                            $morningNote =
                                collect($morningSchedules)
                                    ->pluck('Note')
                                    ->filter()
                                    ->first()
                                    ?? '';

                            $afternoonNote =
                                collect($afternoonSchedules)
                                    ->pluck('Note')
                                    ->filter()
                                    ->first()
                                    ?? '';

                        @endphp

                        <div class="day-column">

                            <div
                                class="shift-card
                                morning-card
                                {{ $morningStatus === 'Available' ? 'active' : '' }}
                                {{ $morningStatus === 'Off' ? 'off show-reason' : '' }}
                                {{ $isPastWeek ? 'past-week' : '' }}"
                                data-shift="morning"
                                data-status="{{ $morningStatus }}"
                            >

                                <div class="shift-icon">

                                    <i class="fas fa-sun"></i>

                                </div>

                                <div class="shift-title">

                                    Morning

                                </div>

                                <ul class="shift-time-list">

                                    @foreach(
                                        $morningSlots
                                        as $slot
                                    )

                                        <li class="shift-time-item">

                                            <i class="fas fa-circle"></i>

                                            <span>

                                                {{ $slot['start'] }}
                                                -
                                                {{ $slot['end'] }}

                                            </span>

                                        </li>

                                    @endforeach

                                </ul>

                                <div
                                    class="shift-status
                                    morning-status-text
                                    {{ $morningStatus === 'Available' ? 'available' : '' }}
                                    {{ $morningStatus === 'Off' ? 'off' : '' }}
                                    {{ $morningStatus === '' ? 'pending' : '' }}"
                                >

                                    @if($morningStatus === 'Available')

                                        Available

                                    @elseif($morningStatus === 'Off')

                                        Day Off

                                    @else

                                        Select status

                                    @endif

                                </div>

                                @if(!$isPastWeek)

                                    <div class="shift-options">

                                        <button
                                            type="button"
                                            class="shift-option"
                                            onclick="setShiftStatus(
                                                event,
                                                this.closest('.morning-card'),
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
                                                this.closest('.morning-card'),
                                                'Off'
                                            )"
                                        >

                                            <i class="fas fa-ban"></i>

                                            Off

                                        </button>

                                    </div>

                                    <div class="reason-box">

                                        <label class="reason-label">

                                            Reason for day off

                                        </label>

                                        <textarea
                                            class="reason-input"
                                            placeholder="Enter reason..."
                                        >{{ $morningNote }}</textarea>

                                    </div>

                                @endif

                                @foreach(
                                    $morningSlots
                                    as $slotIndex => $slot
                                )

                                    @php

                                        $schedule =
                                            $morningSchedules[
                                                $slotIndex
                                            ];

                                        $scheduleIndex =
                                            ($index * 6)
                                            + $slotIndex;

                                    @endphp

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][ScheduleId]"
                                        value="{{ $schedule?->ScheduleId ?? '' }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][WorkDate]"
                                        value="{{ $date->toDateString() }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][StartTime]"
                                        value="{{ $slot['start'] }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][EndTime]"
                                        value="{{ $slot['end'] }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][Status]"
                                        value="{{ $morningStatus }}"
                                        class="morning-status-input"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][Note]"
                                        value="{{ $morningNote }}"
                                        class="morning-note-input"
                                    >

                                @endforeach

                            </div>

                            <div
                                class="shift-card
                                afternoon-card
                                {{ $afternoonStatus === 'Available' ? 'active' : '' }}
                                {{ $afternoonStatus === 'Off' ? 'off show-reason' : '' }}
                                {{ $isPastWeek ? 'past-week' : '' }}"
                                data-shift="afternoon"
                                data-status="{{ $afternoonStatus }}"
                            >

                                <div class="shift-icon">

                                    <i class="fas fa-cloud-sun"></i>

                                </div>

                                <div class="shift-title">

                                    Afternoon

                                </div>

                                <ul class="shift-time-list">

                                    @foreach(
                                        $afternoonSlots
                                        as $slot
                                    )

                                        <li class="shift-time-item">

                                            <i class="fas fa-circle"></i>

                                            <span>

                                                {{ $slot['start'] }}
                                                -
                                                {{ $slot['end'] }}

                                            </span>

                                        </li>

                                    @endforeach

                                </ul>

                                <div
                                    class="shift-status
                                    afternoon-status-text
                                    {{ $afternoonStatus === 'Available' ? 'available' : '' }}
                                    {{ $afternoonStatus === 'Off' ? 'off' : '' }}
                                    {{ $afternoonStatus === '' ? 'pending' : '' }}"
                                >

                                    @if($afternoonStatus === 'Available')

                                        Available

                                    @elseif($afternoonStatus === 'Off')

                                        Day Off

                                    @else

                                        Select status

                                    @endif

                                </div>

                                @if(!$isPastWeek)

                                    <div class="shift-options">

                                        <button
                                            type="button"
                                            class="shift-option"
                                            onclick="setShiftStatus(
                                                event,
                                                this.closest('.afternoon-card'),
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
                                                this.closest('.afternoon-card'),
                                                'Off'
                                            )"
                                        >

                                            <i class="fas fa-ban"></i>

                                            Off

                                        </button>

                                    </div>

                                    <div class="reason-box">

                                        <label class="reason-label">

                                            Reason for day off

                                        </label>

                                        <textarea
                                            class="reason-input"
                                            placeholder="Enter reason..."
                                        >{{ $afternoonNote }}</textarea>

                                    </div>

                                @endif

                                @foreach(
                                    $afternoonSlots
                                    as $slotIndex => $slot
                                )

                                    @php

                                        $schedule =
                                            $afternoonSchedules[
                                                $slotIndex
                                            ];

                                        $scheduleIndex =
                                            ($index * 6)
                                            + 3
                                            + $slotIndex;

                                    @endphp

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][ScheduleId]"
                                        value="{{ $schedule?->ScheduleId ?? '' }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][WorkDate]"
                                        value="{{ $date->toDateString() }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][StartTime]"
                                        value="{{ $slot['start'] }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][EndTime]"
                                        value="{{ $slot['end'] }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][Status]"
                                        value="{{ $afternoonStatus }}"
                                        class="afternoon-status-input"
                                    >

                                    <input
                                        type="hidden"
                                        name="schedules[{{ $scheduleIndex }}][Note]"
                                        value="{{ $afternoonNote }}"
                                        class="afternoon-note-input"
                                    >

                                @endforeach

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

            @if(!$isPastWeek)

                <div class="availability-actions">

                    <button
                        type="submit"
                        class="btn btn-save"
                    >

                        <i class="fas fa-save mr-2"></i>

                        Save Schedule

                    </button>

                </div>

            @endif

        </form>

    </div>

</div>

<script>

    function changeWeek(week)
    {
        const url =
            new URL(
                window.location.href
            );

        url.searchParams.set(
            'week',
            week
        );

        window.location.href =
            url.toString();
    }

    function setShiftStatus(
        event,
        card,
        status
    )
    {
        event.stopPropagation();

        if (!card) {
            return;
        }

        const shift =
            card.dataset.shift;

        card.dataset.status =
            status;

        const statusInputs =
            card.querySelectorAll(
                '.'
                + shift
                + '-status-input'
            );

        const noteInputs =
            card.querySelectorAll(
                '.'
                + shift
                + '-note-input'
            );

        const statusText =
            card.querySelector(
                '.'
                + shift
                + '-status-text'
            );

        const reasonBox =
            card.querySelector(
                '.reason-box'
            );

        const reasonInput =
            card.querySelector(
                '.reason-input'
            );

        statusInputs.forEach(
            function(input) {

                input.value =
                    status;

            }
        );

        if (
            status === 'Off'
        ) {

            if (reasonBox) {

                reasonBox.style.display =
                    'block';

            }

            if (statusText) {

                statusText.classList.remove(
                    'available'
                );

                statusText.classList.remove(
                    'pending'
                );

                statusText.classList.add(
                    'off'
                );

                statusText.textContent =
                    'Day Off';

            }

            card.classList.remove(
                'active'
            );

            card.classList.add(
                'off'
            );

            card.classList.add(
                'show-reason'
            );

        }

        if (
            status === 'Available'
        ) {

            if (reasonInput) {

                reasonInput.value =
                    '';

            }

            noteInputs.forEach(
                function(input) {

                    input.value =
                        '';

                }
            );

            if (reasonBox) {

                reasonBox.style.display =
                    'none';

            }

            if (statusText) {

                statusText.classList.remove(
                    'off'
                );

                statusText.classList.remove(
                    'pending'
                );

                statusText.classList.add(
                    'available'
                );

                statusText.textContent =
                    'Available';

            }

            card.classList.remove(
                'off'
            );

            card.classList.remove(
                'show-reason'
            );

            card.classList.add(
                'active'
            );

        }

    }

    document
        .querySelectorAll(
            '.reason-input'
        )
        .forEach(
            function(textarea) {

                textarea.addEventListener(
                    'input',
                    function() {

                        const card =
                            textarea.closest(
                                '.shift-card'
                            );

                        if (!card) {
                            return;
                        }

                        const shift =
                            card.dataset.shift;

                        const noteInputs =
                            card.querySelectorAll(
                                '.'
                                + shift
                                + '-note-input'
                            );

                        noteInputs.forEach(
                            function(input) {

                                input.value =
                                    textarea.value;

                            }
                        );

                    }
                );

            }
        );

    const availabilityForm =
        document.getElementById(
            'availabilityForm'
        );

    if (availabilityForm) {

        availabilityForm.addEventListener(
            'submit',
            function(event) {

                let valid =
                    true;

                const cards =
                    document.querySelectorAll(
                        '#availabilityForm .shift-card'
                    );

                cards.forEach(
                    function(card) {

                        if (
                            card.classList.contains(
                                'past-week'
                            )
                        ) {
                            return;
                        }

                        const status =
                            card.dataset.status;

                        const reason =
                            card.querySelector(
                                '.reason-input'
                            );

                        if (
                            !status
                        ) {

                            valid =
                                false;

                            card.style.borderColor =
                                '#dc3545';

                        }

                        if (
                            status === 'Off'
                        ) {

                            if (
                                !reason ||
                                reason.value.trim() === ''
                            ) {

                                valid =
                                    false;

                                card.classList.add(
                                    'show-reason'
                                );

                                if (reason) {

                                    reason.focus();

                                }

                                card.style.borderColor =
                                    '#dc3545';

                            }

                        }

                    }
                );

                if (!valid) {

                    event.preventDefault();

                }

            }
        );

    }

</script>

@endsection