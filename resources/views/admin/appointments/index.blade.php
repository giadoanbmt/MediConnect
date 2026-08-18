@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Appointment Management</h1>
            <p class="text-slate-500 text-sm">View appointment list filtered by status</p>
        </div>
    </div>

    <div class="flex border-b border-slate-200 space-x-2 overflow-x-auto">
        <a href="{{ route('admin.appointments.index', ['status' => 'All']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ $status === 'All' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>All</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-slate-100 text-slate-700 font-bold">{{ $counts['All'] }}</span>
        </a>

        <a href="{{ route('admin.appointments.index', ['status' => 'Pending']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ $status === 'Pending' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Pending</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-800 font-bold">{{ $counts['Pending'] }}</span>
        </a>

        <a href="{{ route('admin.appointments.index', ['status' => 'Approved']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ $status === 'Approved' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Approved</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-800 font-bold">{{ $counts['Approved'] }}</span>
        </a>

        <a href="{{ route('admin.appointments.index', ['status' => 'Rejected']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ in_array($status, ['Rejected', 'Cancelled']) ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Cancelled / Rejected</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800 font-bold">{{ $counts['Rejected'] }}</span>
        </a>

        <a href="{{ route('admin.appointments.index', ['status' => 'Completed']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ $status === 'Completed' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Completed</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800 font-bold">{{ $counts['Completed'] }}</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Patient</th>
                        <th class="py-3.5 px-4">Doctor & Room</th>
                        <th class="py-3.5 px-4">Date & Time Slot</th>
                        <th class="py-3.5 px-4">Symptoms / Reason</th>
                        <th class="py-3.5 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($appointments as $item)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-800">{{ $item->PatientName ?? 'Patient #' . $item->UserId }}</div>
                            <div class="text-xs text-slate-500">{{ $item->PatientEmail }}</div>
                        </td>

                        <td class="py-4 px-4">
                            <div class="font-semibold text-blue-700">Dr. {{ $item->DoctorName ?? 'Doctor' }}</div>
                            <div class="text-xs text-slate-500 flex items-center mt-0.5">
                                <i class="fa-solid fa-door-open mr-1 text-slate-400"></i>
                                {{ $item->RoomNumber ? 'Room ' . $item->RoomNumber : 'Room not assigned' }}
                            </div>
                        </td>

                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($item->AppointmentDate)->format('d/m/Y') }}</div>
                            <div class="text-xs text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 inline-block mt-0.5 font-mono">
                                {{ $item->StartTime ? \Carbon\Carbon::parse($item->StartTime)->format('H:i') : '' }} - {{ $item->EndTime ? \Carbon\Carbon::parse($item->EndTime)->format('H:i') : '' }}
                            </div>
                        </td>

                        <td class="py-4 px-4 max-w-xs">
                            <p class="text-xs text-slate-600 line-clamp-2" title="{{ $item->Reason }}">
                                {{ $item->Reason ?? 'No information available' }}
                            </p>
                        </td>

                        <td class="py-4 px-4">
                            @if($item->Status === 'Pending')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 inline-block">Pending</span>
                            @elseif(in_array($item->Status, ['Approved', 'Accept', 'Accepted']))
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-block">Approved</span>
                            @elseif(in_array(strtolower($item->Status), ['cancelled', 'rejected', 'reject']))
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200 inline-block">Cancelled</span>
                            @if(!empty($item->CancellationReason))
                            <div class="mt-1 text-xs text-red-600 italic">
                                <span class="font-medium">Reason:</span> {{ $item->CancellationReason }}
                            </div>
                            @endif
                            @elseif($item->Status === 'Completed')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 inline-block">Completed</span>
                            @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 inline-block">{{ $item->Status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">
                            <i class="fa-regular fa-calendar-xmark text-3xl mb-2 block"></i>
                            No appointments found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection