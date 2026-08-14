@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Title & Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Doctor Management</h1>
            <p class="text-slate-500 text-sm">List of all Doctor accounts and their details</p>
        </div>
        <a href="{{ route('admin.doctors.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow transition">
            <i class="fa-solid fa-user-doctor mr-2"></i> Add New Doctor
        </a>
    </div>

    <!-- Alert Thông báo -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center">
        <i class="fa-solid fa-circle-check mr-2 text-emerald-500"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center">
        <i class="fa-solid fa-circle-exclamation mr-2 text-red-500"></i>
        {{ session('error') }}
    </div>
    @endif

    <!-- Bảng danh sách Bác sĩ -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Thanh cuộn ngang khi bảng quá rộng -->
        <div class="overflow-x-auto max-w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4 text-center">No.</th>
                        <th class="px-6 py-4">Doctor Name</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Phone Number</th>
                        <th class="px-6 py-4 text-center">Gender</th>
                        <th class="px-6 py-4">Specialization</th>
                        <th class="px-6 py-4">Clinic Room</th>
                        <th class="px-6 py-4">Qualifications</th>
                        <th class="px-6 py-4">City</th>
                        <th class="px-6 py-4">Address</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
                    @forelse($doctors as $doctor)
                    <tr class="hover:bg-slate-50/50 transition">
                        <!-- Số thứ tự tính theo phân trang -->
                        <td class="px-6 py-4 font-medium text-slate-500 text-center">
                            {{ $doctors->firstItem() + $loop->index }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-slate-900">
                            {{ $doctor->FullName }}
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $doctor->Username }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $doctor->Email }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $doctor->PhoneNumber ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if(($doctor->Gender ?? '') === 'Male')
                            <span class="text-blue-600"><i class="fa-solid fa-mars mr-1"></i> Male</span>
                            @elseif(($doctor->Gender ?? '') === 'Female')
                            <span class="text-pink-600"><i class="fa-solid fa-venus mr-1"></i> Female</span>
                            @else
                            <span class="text-slate-400">N/A</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if(!empty($doctor->SpecializationName))
                            <span class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                {{ $doctor->SpecializationName }}
                            </span>
                            @else
                            <span class="text-slate-400">N/A</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-slate-700 font-medium">
                            @if(!empty($doctor->RoomName))
                            {{ $doctor->RoomName }} @if($doctor->RoomNumber) ({{ $doctor->RoomNumber }}) @endif
                            @else
                            <span class="text-slate-400">Unassigned</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $doctor->Qualifications ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $doctor->CityName ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-slate-600 max-w-xs truncate" title="{{ $doctor->Address }}">
                            {{ $doctor->Address ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.doctors.edit', $doctor->DoctorId) }}" class="text-blue-600 hover:text-blue-800 font-medium text-xs flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.doctors.destroy', $doctor->DoctorId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this doctor?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-xs flex items-center">
                                        <i class="fa-solid fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="px-6 py-8 text-center text-slate-400">
                            <i class="fa-solid fa-user-doctor text-2xl mb-2 block"></i>
                            There are no doctor accounts in the system.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Links Phân Trang (15 items/trang) -->
        @if($doctors->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $doctors->links() }}
        </div>
        @endif
    </div>
</div>
@endsection