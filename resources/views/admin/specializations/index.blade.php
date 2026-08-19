@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Management of Specializations and Clinic Rooms</h1>
            <p class="text-slate-500 text-sm">Manage specialization information and configure associated clinic rooms</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm space-y-1">
        @foreach($errors->all() as $error)
        <p class="flex items-center space-x-2">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            <span>{{ $error }}</span>
        </p>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Thêm Chuyên Khoa Mới -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 h-fit space-y-4">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center space-x-2">
                <i class="fa-solid fa-plus-circle text-blue-600"></i>
                <span>Add Specialization</span>
            </h2>

            <form action="{{ route('admin.specializations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Specialization Name <span class="text-red-500">*</span></label>
                    <input type="text" name="SpecializationName" value="{{ old('SpecializationName') }}" required placeholder="e.g., Cardiology" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Short Description</label>
                    <textarea name="Description" rows="2" placeholder="Short description..." class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ old('Description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Detailed Content</label>
                    <textarea name="Content" rows="3" placeholder="Detailed content..." class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ old('Content') }}</textarea>
                </div>

                <!-- Khởi tạo phòng khám đầu tiên -->
                <div class="pt-3 border-t border-slate-100 space-y-3">
                    <span class="text-xs font-bold text-slate-500 uppercase">Add Clinic Room (Optional)</span>
                    <div class="space-y-2">
                        <input type="text" name="RoomName" value="{{ old('RoomName') }}" placeholder="Room Name (e.g., Joint Clinic 1)" class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="RoomNumber" value="{{ old('RoomNumber') }}" placeholder="Room Number (e.g., 501)" class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            <input type="text" name="LocationFloor" value="{{ old('LocationFloor') }}" placeholder="Floor (e.g., Floor 5)" class="w-full px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    Save Specialization
                </button>
            </form>
        </div>

        <!-- Danh sách Specialization + Clinic Rooms -->
        <div class="lg:col-span-2 space-y-4">
            @forelse($specializations as $spec)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start space-x-3">
                        @if($spec->ImageUrl)
                        <img src="{{ asset($spec->ImageUrl) }}" alt="{{ $spec->SpecializationName }}" class="w-14 h-14 object-cover rounded-lg border border-slate-200 shrink-0">
                        @else
                        <div class="w-14 h-14 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center shrink-0 text-slate-400">
                            <i class="fa-solid fa-image text-xl"></i>
                        </div>
                        @endif

                        <div>
                            <h3 class="text-lg font-bold text-slate-800">{{ $spec->SpecializationName }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $spec->Description ?? 'Do not have a short description' }}</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.specializations.destroy', $spec->SpecializationId) }}" method="POST" onsubmit="return confirm('Delete this specialization and all its clinic rooms?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-slate-400 hover:text-red-600 p-1.5 rounded-lg transition" title="Delete specialization">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </form>
                </div>

                <!-- Danh sách các Room thuộc Specialization -->
                <div class="space-y-2 pt-3 border-t border-slate-100">
                    <span class="text-xs font-semibold text-slate-400 uppercase">List of Clinic Rooms</span>
                    <div class="flex flex-wrap gap-2">
                        @forelse($spec->clinicRooms as $room)
                        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            <i class="fa-solid fa-door-open text-blue-500"></i>
                            <span>{{ $room->RoomName }}</span>
                            @if($room->RoomNumber)
                            <span class="font-normal text-blue-600">(Mã: {{ $room->RoomNumber }})</span>
                            @endif
                            @if($room->LocationFloor)
                            <span class="text-[11px] text-slate-400 border-l border-blue-200 pl-1.5 ml-0.5">{{ $room->LocationFloor }}</span>
                            @endif
                            <form action="{{ route('admin.specializations.destroyRoom', $room->RoomId) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="hover:text-red-600 ml-1"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </span>
                        @empty
                        <span class="text-xs text-slate-400 italic">Do not have any clinic rooms.</span>
                        @endforelse
                    </div>
                </div>

                <!-- Form Thêm nhanh Room mới -->
                <form action="{{ route('admin.specializations.addRoom', $spec->SpecializationId) }}" method="POST" class="pt-2">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-7 gap-2">
                        <input type="text" name="RoomName" required placeholder=" Enter Room Name (Ex: Room Example)" class="sm:col-span-3 px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <input type="text" name="RoomNumber" required placeholder="Enter Room Number (Ex: 501)" class="sm:col-span-2 px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <input type="text" name="LocationFloor" placeholder="Enter Floor (Ex: Floor 5)" class="sm:col-span-2 px-3 py-1.5 text-xs border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="mt-2 text-right">
                        <button type="submit" class="px-4 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-lg transition">
                            + Add Room
                        </button>
                    </div>
                </form>
            </div>
            @empty
            <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-slate-400">
                <i class="fa-solid fa-stethoscope text-3xl mb-2 block"></i>
                Do not have any specializations in the system.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection