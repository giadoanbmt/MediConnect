@extends('components.layouts.patient.dashboard')
@section('title', 'My Appointments - MediConnect')

@section('content')

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Doctor</th>
                <th>Specialization</th>
                <th>Room</th>
                <th>Appointment date</th>
                <th>Time</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $app)
            @php
            $isPast = \Carbon\Carbon::parse($app->AppointmentDate)->lt(\Carbon\Carbon::today());
            $isCancelled = ($app->Status === 'Cancelled');
            $isReadOnly = $isPast || $isCancelled;
            @endphp

            <tr
                @if($isReadOnly)
                style="opacity: 0.55; background-color: #f8f9fa;"
                @endif>
                <td><strong>#{{ $app->AppointmentId }}</strong></td>
                <td>{{ $app->DoctorName }}</td>
                <td>{{ $app->SpecializationName ?? 'N/A' }}</td>
                <td><span class="badge badge-light border">Room {{ $app->RoomNumber ?? $app->RoomId ?? 'N/A' }}</span></td>
                <td>{{ \Carbon\Carbon::parse($app->AppointmentDate)->format('d/m/Y') }}</td>
                <td>{{ $app->StartTime }} - {{ $app->EndTime }}</td>
                <td>
                    @if($isCancelled)
                    <span class="badge badge-danger text-uppercase fw-bold">CANCELLED</span>
                    @elseif($isPast)
                    <span class="badge badge-secondary">Appointment date has passed</span>
                    @elseif($app->Status === 'Pending')
                    <span class="badge badge-warning">Pending Confirmation</span>
                    @else
                    <span class="badge badge-success">{{ $app->Status }}</span>
                    @endif
                </td>
                <td class="text-center" style="white-space: nowrap;">
                    @if(!$isReadOnly)
                    <div class="d-inline-flex gap-1 align-items-center">
                        <!-- Reschedule -->
                        <a href="{{ route('patient.appointments.reschedule', $app->AppointmentId) }}"
                            class="btn btn-xs btn-outline-primary px-2 py-1"
                            style="font-size: 11px; font-weight: 600;">
                            <i class="icofont-ui-edit mr-1"></i>Reschedule
                        </a>

                        <!-- Cancel -->
                        <form action="{{ route('patient.appointments.cancel', $app->AppointmentId) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                            @csrf
                            <button type="submit"
                                class="btn btn-xs btn-outline-danger px-2 py-1"
                                style="font-size: 11px; font-weight: 600;">
                                <i class="icofont-close-line mr-1"></i>Cancel
                            </button>
                        </form>
                    </div>
                    @else
                    <span class="text-muted small"><i>Unable to edit.</i></span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4">You don't have any appointments yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection