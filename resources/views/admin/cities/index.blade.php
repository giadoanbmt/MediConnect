@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Management of Provinces/Cities and Districts</h1>
            <p class="text-slate-500 text-sm">Configure the list of locations for branches and doctors</p>
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
        <!-- Form Thêm Mới -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 h-fit space-y-4">
            <h2 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center space-x-2">
                <i class="fa-solid fa-plus-circle text-blue-600"></i>
                <span>Add New Location</span>
            </h2>

            <form action="{{ route('admin.cities.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Province/City <span class="text-red-500">*</span></label>
                    <input type="text" name="CityName" value="{{ old('CityName') }}" required placeholder="e.g., Ho Chi Minh City" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">District (Optional)</label>
                    <input type="text" name="DistrictName" value="{{ old('DistrictName') }}" placeholder="e.g., District 1" class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                    Save Location
                </button>
            </form>
        </div>

        <!-- Danh Sách -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Province/City</th>
                        <th class="px-4 py-3">District</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cities as $city)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-semibold text-slate-800">#{{ $city->CityId }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $city->CityName }}</td>
                        <td class="px-4 py-3">
                            @if($city->DistrictName)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $city->DistrictName }}
                            </span>
                            @else
                            <span class="text-xs text-slate-400 italic">Not specified</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('admin.cities.destroy', $city->CityId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this location?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 transition">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                            No Province/City data available.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection