@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Title & Button -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">User Management</h1>
            <p class="text-slate-500 text-sm">List of all Patients, Doctors, and Admins</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow transition flex items-center">
            <i class="fa-solid fa-user-plus mr-2"></i> Create New Account
        </a>
    </div>

    <!-- Alert Thông báo -->
    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex items-center">
        <i class="fa-solid fa-circle-check mr-2 text-emerald-500"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Bảng danh sách Users -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition">
                        <!-- <td class="px-6 py-4 font-medium text-slate-900">#{{ $user->UserId }}</td> -->
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $users->firstItem() + $loop->index }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $user->Username }}</td>
                        <td class="px-6 py-4">
                            <div>{{ $user->Email }}</div>
                            <div class="text-xs text-slate-400">@ {{ $user->Username }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->AccountType === 'doctor')
                            <span class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Doctor</span>
                            @elseif($user->Role == 1)
                            <span class="px-2.5 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">Administrator</span>
                            @elseif($user->Role == 2)
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.users.edit', $user->UserId) }}?type={{ $user->AccountType }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', ['id' => $user->UserId, 'type' => $user->AccountType]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this account?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">There are no accounts in the system.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection