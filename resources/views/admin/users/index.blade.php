@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Title, Search Form & Button -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Patient Management</h1>
            <p class="text-slate-500 text-sm">List of registered Patients in the system</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <!-- Form Tìm Kiếm -->
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <input type="text"
                        name="keyword"
                        value="{{ $keyword }}"
                        placeholder="Search name, username, email..."
                        class="w-full pl-9 pr-8 py-2 text-sm bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

                    @if(!empty($keyword))
                    <a href="{{ route('admin.users.index') }}"
                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    @endif
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                    Search
                </button>
            </form>

            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow transition whitespace-nowrap">
                <i class="fa-solid fa-user-plus mr-2"></i> Create New Patient
            </a>
        </div>
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

    <!-- Bảng danh sách Bệnh nhân -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto max-w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4 text-center">No.</th>
                        <th class="px-6 py-4">Full Name</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">Email Address</th>
                        <th class="px-6 py-4 text-center">Gender</th>
                        <th class="px-6 py-4">Address</th>
                        <th class="px-6 py-4 text-center">Created At</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-medium text-slate-500 text-center">
                            {{ $users->firstItem() + $loop->index }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-slate-900">
                            {{ $user->FullName ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ $user->Username }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $user->Email }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if(($user->Gender ?? '') === 'Male')
                            <span class="text-blue-600"><i class="fa-solid fa-mars mr-1"></i> Male</span>
                            @elseif(($user->Gender ?? '') === 'Female')
                            <span class="text-pink-600"><i class="fa-solid fa-venus mr-1"></i> Female</span>
                            @else
                            <span class="text-slate-400">N/A</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-slate-600 max-w-xs truncate" title="{{ $user->Address }}">
                            {{ $user->Address ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-center text-xs text-slate-500">
                            {{ $user->CreatedAt ? \Carbon\Carbon::parse($user->CreatedAt)->format('d/m/Y') : 'N/A' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.users.edit', $user->UserId) }}" class="text-blue-600 hover:text-blue-800 font-medium text-xs flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->UserId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient account?')" class="inline">
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
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400">
                            <i class="fa-solid fa-user-slash text-2xl mb-2 block"></i>
                            @if(!empty($keyword))
                            No patients found matching "{{ $keyword }}".
                            @else
                            There are no patient accounts in the system.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection