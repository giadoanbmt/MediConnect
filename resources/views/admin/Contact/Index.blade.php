@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Contact Request Management</h1>
            <p class="text-slate-500 text-sm">Review and respond to inquiries sent by patients</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex justify-between items-center shadow-sm">
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <div class="flex border-b border-slate-200 space-x-2 overflow-x-auto">
        <a href="{{ route('admin.contact.index', ['status' => 'All']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ $status === 'All' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>All</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-slate-100 text-slate-700 font-bold">{{ $counts['All'] }}</span>
        </a>

        <a href="{{ route('admin.contact.index', ['status' => 'Pending']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ $status === 'Pending' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Pending</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-800 font-bold">{{ $counts['Pending'] }}</span>
        </a>

        <a href="{{ route('admin.contact.index', ['status' => 'Resolved']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 whitespace-nowrap {{ $status === 'Resolved' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Resolved</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-800 font-bold">{{ $counts['Resolved'] }}</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Sender Information</th>
                        <th class="py-3.5 px-4">Subject & Content</th>
                        <th class="py-3.5 px-4">Submitted At</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($queries as $item)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-4">
                            <div class="font-semibold text-slate-800">{{ $item->SenderName }}</div>
                            <div class="text-xs text-slate-500 flex items-center mt-0.5">
                                <i class="fa-regular fa-envelope mr-1.5 text-slate-400"></i> {{ $item->Email }}
                            </div>
                            <div class="text-xs text-slate-500 flex items-center mt-0.5">
                                <i class="fa-solid fa-phone mr-1.5 text-slate-400"></i> {{ $item->PhoneNumber }}
                            </div>
                        </td>

                        <td class="py-4 px-4 max-w-xs">
                            <div class="font-medium text-slate-800 truncate" title="{{ $item->Subject }}">
                                {{ $item->Subject ?? 'No Subject' }}
                            </div>
                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5" title="{{ $item->MessageText }}">
                                {{ $item->MessageText }}
                            </p>
                        </td>

                        <td class="py-4 px-4 whitespace-nowrap text-slate-600 text-xs">
                            <i class="fa-regular fa-clock mr-1 text-slate-400"></i>
                            {{ $item->SubmittedAt ? \Carbon\Carbon::parse($item->SubmittedAt)->format('d/m/Y H:i') : 'N/A' }}
                        </td>

                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($item->Status === 'Pending')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center space-x-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                <span>Pending</span>
                            </span>
                            @elseif($item->Status === 'Resolved')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center space-x-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span>Resolved</span>
                            </span>
                            @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 inline-block">{{ $item->Status }}</span>
                            @endif
                        </td>

                        <td class="py-4 px-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.contact.show', $item->QueryId) }}"
                                class="inline-flex items-center space-x-1 px-3 py-1.5 text-xs font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition">
                                <i class="fa-regular fa-eye"></i>
                                <span>{{ $item->Status === 'Pending' ? 'Respond' : 'View Details' }}</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">
                            <i class="fa-regular fa-folder-open text-3xl mb-2 block"></i>
                            No contact requests found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
            {{ $queries->links() }}
        </div>
    </div>
</div>
@endsection