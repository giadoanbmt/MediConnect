@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div class="space-y-1">
            <a href="{{ route('admin.contact.index') }}" class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800 transition mb-1">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Contact List
            </a>
            <h1 class="text-2xl font-bold text-slate-800">Inquiry Details #{{ $query->QueryId }}</h1>
        </div>

        <div>
            @if ($query->Status === 'Resolved')
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Resolved</span>
            </span>
            @else
            <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span>Pending Response</span>
            </span>
            @endif
        </div>
    </div>

    @if ($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm space-y-1">
        @foreach ($errors->all() as $error)
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            <span>{{ $error }}</span>
        </div>
        @endforeach
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-6">
        <h2 class="text-base font-semibold text-slate-800 border-b border-slate-100 pb-3 flex items-center space-x-2">
            <i class="fa-solid fa-user-gear text-blue-600"></i>
            <span>Patient Inquiry Information</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-lg border border-slate-100">
            <div>
                <span class="block text-xs font-medium text-slate-400 uppercase">Sender Name</span>
                <span class="text-sm font-semibold text-slate-800">{{ $query->SenderName }}</span>
            </div>
            <div>
                <span class="block text-xs font-medium text-slate-400 uppercase">Email Address</span>
                <span class="text-sm font-semibold text-blue-600">{{ $query->Email }}</span>
            </div>
            <div>
                <span class="block text-xs font-medium text-slate-400 uppercase">Phone Number</span>
                <span class="text-sm font-semibold text-slate-800">{{ $query->PhoneNumber }}</span>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase block mb-1">Subject</span>
                <div class="text-base font-semibold text-slate-800 bg-white border border-slate-200 rounded-lg px-4 py-2.5">
                    {{ $query->Subject ?? 'No Subject Provided' }}
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-semibold text-slate-400 uppercase">Message Content</span>
                    <span class="text-xs text-slate-400">
                        <i class="fa-regular fa-clock mr-1"></i>
                        Submitted: {{ $query->SubmittedAt ? \Carbon\Carbon::parse($query->SubmittedAt)->format('d/m/Y H:i') : 'N/A' }}
                    </span>
                </div>
                <div class="text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-lg p-4 leading-relaxed whitespace-pre-line">
                    {{ $query->MessageText }}
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h2 class="text-base font-semibold text-slate-800 border-b border-slate-100 pb-3 flex items-center space-x-2">
            <i class="fa-solid fa-reply text-emerald-600"></i>
            <span>Admin Response</span>
        </h2>

        @if($query->Status === 'Resolved')
        <div class="space-y-3">
            <div class="bg-emerald-50/60 border border-emerald-200 text-slate-800 rounded-lg p-4 space-y-2">
                <p class="text-sm leading-relaxed whitespace-pre-line text-slate-700">{{ $query->AdminNotes }}</p>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-500 pt-2 px-1">
                <div>
                    <span class="font-medium">Responded by:</span>
                    <span class="text-slate-700 font-semibold">{{ $query->respondedByAdmin->FullName ?? 'Admin' }}</span>
                </div>
                <div>
                    <i class="fa-regular fa-circle-check text-emerald-600 mr-1"></i>
                    <span>Responded on: {{ $query->RespondedAt ? \Carbon\Carbon::parse($query->RespondedAt)->format('d/m/Y H:i') : 'N/A' }}</span>
                </div>
            </div>
        </div>
        @else
        <form action="{{ route('admin.contact.respond', $query->QueryId) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="admin_notes" class="block text-sm font-semibold text-slate-700 mb-1">
                    Response Message <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="admin_notes"
                    name="admin_notes"
                    rows="5"
                    required
                    placeholder="Type your response to the patient here. This message will be saved to the database and emailed directly to {{ $query->Email }}..."
                    class="w-full px-3.5 py-2.5 text-sm text-slate-800 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">{{ old('admin_notes', $query->AdminNotes) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <a href="{{ route('admin.contact.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition flex items-center space-x-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Send Response & Mark Resolved</span>
                </button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection