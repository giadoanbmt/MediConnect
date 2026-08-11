@extends('components.layouts.admin.master')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Appointment Management</h1>
            <p class="text-slate-500 text-sm">Review, approve, or decline patient appointment requests</p>
        </div>
    </div>

    <!-- Alert Thông báo -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <!-- Status Filter Tabs -->
    <div class="flex border-b border-slate-200 space-x-2">
        <a href="{{ route('admin.appointments.index', ['status' => 'Pending']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 {{ $status === 'Pending' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Chờ duyệt</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-800 font-bold">{{ $counts['Pending'] }}</span>
        </a>

        <a href="{{ route('admin.appointments.index', ['status' => 'Approved']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 {{ $status === 'Approved' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Đã gửi Bác sĩ</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-800 font-bold">{{ $counts['Approved'] }}</span>
        </a>

        <a href="{{ route('admin.appointments.index', ['status' => 'Rejected']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 {{ $status === 'Rejected' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Đã từ chối</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800 font-bold">{{ $counts['Rejected'] }}</span>
        </a>

        <a href="{{ route('admin.appointments.index', ['status' => 'All']) }}"
            class="px-4 py-2.5 text-sm font-medium border-b-2 transition flex items-center space-x-2 {{ $status === 'All' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
            <span>Tất cả</span>
            <span class="px-2 py-0.5 text-xs rounded-full bg-slate-100 text-slate-700 font-bold">{{ $counts['All'] }}</span>
        </a>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4">Bệnh nhân</th>
                        <th class="py-3.5 px-4">Bác sĩ & Phòng</th>
                        <th class="py-3.5 px-4">Ngày & Khung giờ</th>
                        <th class="py-3.5 px-4">Triệu chứng</th>
                        <th class="py-3.5 px-4">Trạng thái</th>
                        <th class="py-3.5 px-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($appointments as $item)
                    <tr class="hover:bg-slate-50/80 transition">
                        <!-- Patient Info -->
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-800">{{ $item->PatientName ?? 'Bệnh nhân #' . $item->PatientId }}</div>
                            <div class="text-xs text-slate-500">{{ $item->PatientEmail }}</div>
                        </td>

                        <!-- Doctor & Room -->
                        <td class="py-4 px-4">
                            <div class="font-semibold text-blue-700">Bs. {{ $item->DoctorName ?? 'Mặc định' }}</div>
                            <div class="text-xs text-slate-500 flex items-center mt-0.5">
                                <i class="fa-solid fa-door-open mr-1 text-slate-400"></i>
                                {{ $item->RoomNumber ?? 'Chưa xếp phòng' }}
                            </div>
                        </td>

                        <!-- Date & TimeSlot -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            <div class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($item->AppointmentDate)->format('d/m/Y') }}</div>
                            <div class="text-xs text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 inline-block mt-0.5 font-semibold">
                                {{ $item->TimeSlot }}
                            </div>
                        </td>

                        <!-- Symptoms -->
                        <td class="py-4 px-4 max-w-xs">
                            <p class="text-xs text-slate-600 line-clamp-2" title="{{ $item->Symptoms }}">
                                {{ $item->Symptoms ?? 'Không có thông tin' }}
                            </p>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-4 whitespace-nowrap">
                            @if($item->Status === 'Pending')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Chờ duyệt</span>
                            @elseif($item->Status === 'Approved')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Đã gửi Bác sĩ</span>
                            @elseif($item->Status === 'Rejected')
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200" title="Lý do: {{ $item->RejectReason }}">Đã từ chối</span>
                            @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">{{ $item->Status }}</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-4 text-right whitespace-nowrap space-x-2">
                            @if($item->Status === 'Pending')
                            <!-- Button Approve -->
                            <form action="{{ route('admin.appointments.approve', $item->AppointmentId) }}" method="POST" class="inline-block" onsubmit="return confirm('Xác nhận duyệt và gửi lịch hẹn này cho Bác sĩ?');">
                                @csrf
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-1.5 rounded transition inline-flex items-center">
                                    <i class="fa-solid fa-check mr-1"></i> Duyệt
                                </button>
                            </form>

                            <!-- Button Reject Modal Trigger -->
                            <button onclick="openRejectModal('{{ $item->AppointmentId }}')" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-semibold px-3 py-1.5 rounded transition inline-flex items-center">
                                <i class="fa-solid fa-xmark mr-1"></i> Từ chối
                            </button>
                            @else
                            <span class="text-xs text-slate-400 font-medium">Đã xử lý</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">
                            <i class="fa-regular fa-calendar-xmark text-3xl mb-2 block"></i>
                            Không tìm thấy lịch hẹn nào.
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

<!-- Modal Nhập Lý Do Từ Chối -->
<div id="rejectModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6 space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
            <h3 class="text-lg font-bold text-slate-800">Từ chối lịch hẹn</h3>
            <button onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <form id="rejectForm" method="POST" action="" class="space-y-4">
            @csrf
            <div>
                <label for="reject_reason" class="block text-sm font-semibold text-slate-700 mb-1">Lý do từ chối <span class="text-red-500">*</span></label>
                <textarea id="reject_reason" name="reject_reason" rows="3" required placeholder="Ví dụ: Bác sĩ bận lịch phẫu thuật đột xuất..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg">Hủy</button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">Xác nhận Từ chối</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(appointmentId) {
        const form = document.getElementById('rejectForm');
        form.action = `/admin/appointments/${appointmentId}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection