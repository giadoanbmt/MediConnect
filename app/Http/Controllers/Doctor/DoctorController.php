<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

use App\Models\DoctorSchedule;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\City;
use App\Models\ClinicRoom;
use App\Models\News;
use App\Models\Appointment;

class DoctorController extends Controller
{
    //dashboard
    public function dashboard(): View
    {
        $doctor = Doctor::findOrFail(
            session('doctor_id')
        );

        $today = now()->toDateString();

        // Get today's appointments
        $todayAppointments = Appointment::with('accountUser')
            ->where('DoctorId', $doctor->DoctorId)
            ->whereDate('AppointmentDate', $today)
            ->orderBy('StartTime')
            ->get();

        // Count today's patients
        $todayPatients = $todayAppointments
            ->filter(function ($appointment) {
                return $appointment->accountUser;
            })
            ->unique(function ($appointment) {
                return $appointment->accountUser->getKey();
            })
            ->count();

        // Get today's available schedules
        $availableSlots = DoctorSchedule::where(
            'DoctorId',
            $doctor->DoctorId
        )
            ->whereDate('WorkDate', $today)
            ->where('Status', 'Available')
            ->sum('MaxPatients');

        return view(
            'doctor.dashboard',
            compact(
                'doctor',
                'todayAppointments',
                'todayPatients',
                'availableSlots'
            )
        );
    }

    // Doctor
    public function index(Request $request)
    {
        $query = Doctor::with([
            'city',
            'specialization',
            'clinicRoom'
        ]);

        if ($request->filled('city')) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->where(
                    'CityName',
                    'LIKE',
                    '%' . $request->city . '%'
                )
                    ->orWhere(
                        'DistrictName',
                        'LIKE',
                        '%' . $request->city . '%'
                    );
            });
        }

        if ($request->filled('specialization')) {
            $query->whereHas('specialization', function ($q) use ($request) {
                $q->where(
                    'SpecializationName',
                    'LIKE',
                    '%' . $request->specialization . '%'
                );
            });
        }

        $doctors = $query->get();

        return response()->json($doctors);
    }

    public function show($id)
    {
        $doctor = Doctor::with([
            'city',
            'specialization',
            'clinicRoom',
            'appointments' => function ($q) {
                $q->where('Status', 'Pending')
                    ->where(
                        'AppointmentDate',
                        '>=',
                        now()
                    );
            }
        ])->findOrFail($id);

        return response()->json($doctor);
    }

    // Profile
    public function profile()
    {
        $doctor = Doctor::with([
            'specialization',
            'city',
            'clinicRoom'
        ])->findOrFail(
            session('doctor_id')
        );

        $specializations = Specialization::all();

        $locations = City::orderBy('CityId')
            ->get();

        $cities = $locations
            ->unique(function ($city) {
                return trim($city->CityName);
            })
            ->values();

        $rooms = ClinicRoom::all();

        return view(
            'doctor.profile.profile',
            compact(
                'doctor',
                'specializations',
                'cities',
                'locations',
                'rooms'
            )
        );
    }

    public function updateProfile(Request $request)
    {
        $doctor = Doctor::findOrFail(
            session('doctor_id')
        );

        $validated = $request->validate([
            'FullName' =>
            'required|string|max:255',

            'Gender' =>
            'required|string|max:20',

            'PhoneNumber' =>
            'required|string|max:20',

            'Email' =>
            'required|email|max:255',

            'Qualifications' =>
            'nullable|string|max:255',

            'SpecializationId' =>
            'nullable|exists:Specialization,SpecializationId',

            'CityId' =>
            'nullable|exists:City,CityId',

            'RoomId' =>
            'nullable|exists:ClinicRoom,RoomId',

            'Address' =>
            'nullable|string|max:255',

            'AvatarUrl' =>
            'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $doctor->FullName =
            $validated['FullName'];

        $doctor->Gender =
            $validated['Gender'];

        $doctor->PhoneNumber =
            $validated['PhoneNumber'];

        $doctor->Email =
            $validated['Email'];

        $doctor->Qualifications =
            $validated['Qualifications']
            ?? null;

        $doctor->SpecializationId =
            $validated['SpecializationId']
            ?? null;

        $doctor->CityId =
            $validated['CityId']
            ?? null;

        $doctor->RoomId =
            $validated['RoomId']
            ?? null;

        $doctor->Address =
            $validated['Address']
            ?? null;

        if ($request->hasFile('AvatarUrl')) {
            $file =
                $request->file('AvatarUrl');

            $fileName =
                time()
                . '_avatar-doctor.'
                . $file->getClientOriginalExtension();

            $file->move(
                public_path('uploads/avatars'),
                $fileName
            );

            $doctor->AvatarUrl =
                'uploads/avatars/' . $fileName;
        }

        $doctor->save();

        session([
            'doctor_name' =>
            $doctor->FullName
        ]);

        return redirect()
            ->route('doctor.profile')
            ->with(
                'success',
                'Cập nhật hồ sơ thành công!'
            );
    }

    // News
    public function newsIndex(Request $request)
    {
        // News của bác sĩ
        $query = News::query()
            ->where('AuthorType', 'Doctor')
            ->where('DoctorId', session('doctor_id'))
            ->whereNull('DeletedAt');

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'Title',
                'LIKE',
                '%' . $search . '%'
            );
        }

        // Lấy danh sách News
        $news = $query
            ->orderBy('CreatedAt', 'desc')
            ->get()
            ->map(function ($n) {
                return (object) [
                    'NewsId' => $n->NewsId,
                    'Title' => $n->Title,
                    'Category' => $n->Category,
                    'Content' => $n->Content,
                    'ThumbnailUrl' => $n->ThumbnailUrl,
                    'CreatedAt' => $n->CreatedAt,
                    'Status' => $n->IsPublished
                        ? 'Published'
                        : 'Draft',
                ];
            });

        return view(
            'doctor.news.index',
            compact('news')
        );
    }

    public function createNews()
    {
        return view(
            'doctor.news.create',
            [
                'news' => null
            ]
        );
    }

    public function editNews($id)
    {
        // Find news
        $news = News::where('NewsId', $id)
            ->where('DoctorId', session('doctor_id'))
            ->whereNull('DeletedAt')
            ->firstOrFail();

        // Show edit form
        return view('doctor.news.edit', compact('news'));
    }

    public function storeNews(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'Title' =>
            'required|string|max:300',

            'Category' =>
            'required|string|max:100',

            'Content' =>
            'required|string',

            'ThumbnailUrl' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Default thumbnail
        $thumbnailUrl =
            'images/thumbnails/news-placeholder.png';

        // Upload thumbnail
        if ($request->hasFile('ThumbnailUrl')) {

            $file =
                $request->file('ThumbnailUrl');

            $fileName =
                time()
                . '_news.'
                . $file->getClientOriginalExtension();

            $uploadPath =
                public_path('uploads/thumbnails');

            if (!is_dir($uploadPath)) {
                mkdir(
                    $uploadPath,
                    0755,
                    true
                );
            }

            $file->move(
                $uploadPath,
                $fileName
            );

            $thumbnailUrl =
                'uploads/thumbnails/' . $fileName;
        }

        // Create news
        $news = new News();

        $news->Title =
            $validated['Title'];

        $news->Category =
            $validated['Category'];

        $news->Content =
            $validated['Content'];

        $news->ThumbnailUrl =
            $thumbnailUrl;

        $news->AuthorType =
            'Doctor';

        $news->DoctorId =
            session('doctor_id');

        $news->IsPublished =
            1;

        $news->save();

        // Redirect
        return redirect()
            ->route('doctor.news.index')
            ->with(
                'success',
                'News created successfully!'
            );
    }

    public function updateNews(
        Request $request,
        $id
    ) {
        $news = News::where(
            'NewsId',
            $id
        )
            ->where(
                'AuthorType',
                'Doctor'
            )
            ->where(
                'DoctorId',
                session('doctor_id')
            )
            ->whereNull('DeletedAt')
            ->firstOrFail();

        $validated = $request->validate([
            'Title' =>
            'required|string|max:300',

            'Category' =>
            'required|string|max:100',

            'Content' =>
            'required|string',

            'ThumbnailUrl' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $news->Title =
            $validated['Title'];

        $news->Category =
            $validated['Category'];

        $news->Content =
            $validated['Content'];

        if ($request->hasFile('ThumbnailUrl')) {
            $file =
                $request->file('ThumbnailUrl');

            $fileName =
                time()
                . '_news.'
                . $file->getClientOriginalExtension();

            $uploadPath =
                public_path('uploads/news');

            if (!is_dir($uploadPath)) {
                mkdir(
                    $uploadPath,
                    0755,
                    true
                );
            }

            $file->move(
                $uploadPath,
                $fileName
            );

            $news->ThumbnailUrl =
                'uploads/news/' . $fileName;
        }

        $news->save();

        return redirect()
            ->route('doctor.news.index')
            ->with(
                'success',
                'News updated successfully!'
            );
    }

    public function deleteNews($id)
    {
        $news = News::where('NewsId', $id)
            ->where('DoctorId', session('doctor_id'))
            ->where('AuthorType', 'Doctor')
            ->firstOrFail();

        $news->forceDelete();

        return redirect()
            ->route('doctor.news.index')
            ->with('success', 'Xóa tin tức thành công!');
    }

    /// Availability
public function availability(Request $request)
{
    $doctor = Doctor::findOrFail(
        session('doctor_id')
    );

    $week = $request->input(
        'week',
        now()->startOfWeek()->toDateString()
    );

    $startOfWeek = \Carbon\Carbon::parse($week)
        ->startOfWeek();

    $endOfWeek = $startOfWeek
        ->copy()
        ->endOfWeek();

    $schedules = $doctor->schedules()
        ->whereBetween(
            'WorkDate',
            [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ]
        )
        ->orderBy('WorkDate')
        ->orderBy('StartTime')
        ->get();

    $appointments = Appointment::with('accountUser')
        ->where(
            'DoctorId',
            $doctor->DoctorId
        )
        ->whereBetween(
            'AppointmentDate',
            [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString()
            ]
        )
        ->orderBy('AppointmentDate')
        ->orderBy('StartTime')
        ->get();

    return view(
        'doctor.availability.index',
        compact(
            'doctor',
            'schedules',
            'appointments',
            'startOfWeek'
        )
    );
}

public function saveAvailability(Request $request)
{
    $doctor = Doctor::findOrFail(
        session('doctor_id')
    );

    $validated = $request->validate([
        'schedules' => [
            'required',
            'array',
            'size:14',
        ],

        'schedules.*.WorkDate' => [
            'required',
            'date',
        ],

        'schedules.*.StartTime' => [
            'required',
            'date_format:H:i',
        ],

        'schedules.*.EndTime' => [
            'required',
            'date_format:H:i',
        ],

        'schedules.*.Status' => [
            'required',
            'in:Available,Off',
        ],

        'schedules.*.Note' => [
            'nullable',
            'string',
            'max:255',
        ],
    ]);

    foreach ($validated['schedules'] as $index => $schedule) {

        if (
            $schedule['Status'] === 'Off' &&
            (
                empty($schedule['Note']) ||
                trim($schedule['Note']) === ''
            )
        ) {
            return back()
                ->withErrors([
                    "schedules.$index.Note" =>
                    'A reason is required when a shift is marked as Day Off.'
                ])
                ->withInput();
        }
    }

    foreach ($validated['schedules'] as $schedule) {

        DoctorSchedule::updateOrCreate(
            [
                'DoctorId' =>
                    $doctor->DoctorId,

                'WorkDate' =>
                    $schedule['WorkDate'],

                'StartTime' =>
                    $schedule['StartTime'],
            ],
            [
                'EndTime' =>
                    $schedule['EndTime'],

                'Status' =>
                    $schedule['Status'],

                'Note' =>
                    $schedule['Status'] === 'Off'
                        ? trim($schedule['Note'])
                        : null,
            ]
        );
    }

    return redirect()
        ->route(
            'doctor.availability',
            [
                'week' => \Carbon\Carbon::parse(
                    $validated['schedules'][0]['WorkDate']
                )->startOfWeek()->toDateString()
            ]
        )
        ->with(
            'success',
            'Weekly schedule saved successfully.'
        );
}
// Appointments
public function appointments(Request $request)
{
    // Lấy bác sĩ đang đăng nhập
    $doctor = Doctor::findOrFail(
        session('doctor_id')
    );

    // Xác định kiểu xem: ngày / tuần / tháng
    $view = $request->get(
        'view',
        'week'
    );

    // Nếu view không hợp lệ thì quay về tuần
    if (!in_array(
        $view,
        ['day', 'week', 'month'],
        true
    )) {
        $view = 'week';
    }

    // Lấy ngày đang xem
    $date = $request->get(
        'date',
        now()->toDateString()
    );

    // Kiểm tra ngày, nếu sai thì dùng ngày hiện tại
    try {
        $selectedDate = \Carbon\Carbon::parse(
            $date
        );
    } catch (\Exception $e) {
        $selectedDate = now();
        $date = $selectedDate->toDateString();
    }

    // Lấy trạng thái đang lọc
    $status = $request->get(
        'status',
        'All'
    );

    // Các trạng thái được phép lọc
    $allowedStatuses = [
        'All',
        'Pending',
        'Confirmed',
        'Cancelled',
        'Completed',
    ];

    // Nếu trạng thái không hợp lệ thì lấy tất cả
    if (!in_array(
        $status,
        $allowedStatuses,
        true
    )) {
        $status = 'All';
    }

    // Lấy từ khóa tìm kiếm bệnh nhân
    $search = trim(
        $request->get(
            'search',
            ''
        )
    );

    // Xác định khoảng thời gian cần lấy
    if ($view === 'day') {

        // Xem trong một ngày
        $startDate = $selectedDate
            ->copy()
            ->startOfDay();

        $endDate = $selectedDate
            ->copy()
            ->endOfDay();

    } elseif ($view === 'month') {

        // Xem trong một tháng
        $startDate = $selectedDate
            ->copy()
            ->startOfMonth();

        $endDate = $selectedDate
            ->copy()
            ->endOfMonth();

    } else {

        // Xem trong một tuần
        $startDate = $selectedDate
            ->copy()
            ->startOfWeek();

        $endDate = $selectedDate
            ->copy()
            ->endOfWeek();
    }

    // Đổi khoảng ngày về dạng Y-m-d để query DB
    $startDateString = $startDate
        ->toDateString();

    $endDateString = $endDate
        ->toDateString();

    // Query gốc: chỉ lấy lịch của bác sĩ
    // trong khoảng thời gian đang xem
    $baseQuery = Appointment::query()
        ->where(
            'DoctorId',
            $doctor->DoctorId
        )
        ->whereBetween(
            'AppointmentDate',
            [
                $startDateString,
                $endDateString
            ]
        );

    // Tạo query riêng để lấy danh sách lịch hẹn
    $appointmentsQuery = clone $baseQuery;

    // Lấy luôn thông tin bệnh nhân
    $appointmentsQuery->with(
        'accountUser'
    );

    // Lọc theo trạng thái
    if ($status !== 'All') {

        // Gom tất cả kiểu Cancelled vào một nhóm
        if ($status === 'Cancelled') {

            $appointmentsQuery->whereIn(
                'Status',
                [
                    'Cancelled',
                    'cancelled_by_doctor',
                    'cancelled_by_patient',
                ]
            );

        } else {

            // Các trạng thái còn lại lọc trực tiếp
            $appointmentsQuery->where(
                'Status',
                $status
            );
        }
    }

    // Tìm kiếm theo tên hoặc email bệnh nhân
    if ($search !== '') {

        $appointmentsQuery->whereHas(
            'accountUser',
            function ($q) use ($search) {

                $q->where(
                    'FullName',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'Email',
                    'LIKE',
                    '%' . $search . '%'
                );
            }
        );
    }

    // Lấy danh sách lịch hẹn và sắp xếp theo ngày, giờ
    $appointments = $appointmentsQuery
        ->orderBy(
            'AppointmentDate'
        )
        ->orderBy(
            'StartTime'
        )
        ->get();

    // Tạo query riêng để đếm số lượng theo trạng thái
    // Không áp dụng status filter hiện tại
    $statusCountsQuery = clone $baseQuery;

    // Chỉ lấy Status để tính số lượng
    $allAppointments =
        $statusCountsQuery
            ->select([
                'Status'
            ])
            ->get();

    // Đếm số lịch theo từng trạng thái
    $statusCounts = [
        'All' => $allAppointments->count(),

        'Pending' => $allAppointments
            ->where(
                'Status',
                'Pending'
            )
            ->count(),

        'Confirmed' => $allAppointments
            ->where(
                'Status',
                'Confirmed'
            )
            ->count(),

        'Cancelled' => $allAppointments
            ->filter(
                function ($appointment) {

                    return in_array(
                        $appointment->Status,
                        [
                            'Cancelled',
                            'cancelled_by_doctor',
                            'cancelled_by_patient',
                        ],
                        true
                    );
                }
            )
            ->count(),

        'Completed' => $allAppointments
            ->where(
                'Status',
                'Completed'
            )
            ->count(),
    ];

    // Gửi dữ liệu sang giao diện Appointments
    return view(
        'doctor.appointments.index',
        compact(
            'doctor',
            'appointments',
            'view',
            'date',
            'status',
            'search',
            'statusCounts'
        )
    );
}

// Confirm Appointment
public function confirmAppointment($id)
{
    // Lấy bác sĩ đang đăng nhập
    $doctor = Doctor::findOrFail(
        session('doctor_id')
    );

    // Lấy lịch hẹn thuộc bác sĩ này
    $appointment = Appointment::where(
        'AppointmentId',
        $id
    )
        ->where(
            'DoctorId',
            $doctor->DoctorId
        )
        ->firstOrFail();

    // Chỉ lịch Pending mới được xác nhận
    if ($appointment->Status !== 'Pending') {
        return back()->with(
            'error',
            'This appointment cannot be confirmed.'
        );
    }

    // Chuyển trạng thái sang Confirmed
    $appointment->Status = 'Confirmed';

    // Lưu thay đổi
    $appointment->save();

    // Quay lại trang và báo thành công
    return back()->with(
        'success',
        'Appointment confirmed successfully.'
    );
}

// Cancel Appointment
public function cancelAppointment(Request $request, $id)
{
    // Lấy bác sĩ đang đăng nhập
    $doctor = Doctor::findOrFail(
        session('doctor_id')
    );

    // Kiểm tra lý do hủy
    $validated = $request->validate([
        'CancellationReason' => [
            'required',
            'string',
            'max:255',
        ],
    ]);

    // Lấy lịch hẹn thuộc bác sĩ này
    $appointment = Appointment::where(
        'AppointmentId',
        $id
    )
        ->where(
            'DoctorId',
            $doctor->DoctorId
        )
        ->firstOrFail();

    // Chỉ lịch Pending mới được hủy
    if ($appointment->Status !== 'Pending') {
        return back()->with(
            'error',
            'This appointment cannot be cancelled.'
        );
    }

    // Chuyển trạng thái sang Cancelled
    $appointment->Status = 'Cancelled';

    // Lưu lý do hủy
    $appointment->CancellationReason =
        trim(
            $validated['CancellationReason']
        );

    // Lưu thay đổi
    $appointment->save();

    // Quay lại trang và báo thành công
    return back()->with(
        'success',
        'Appointment cancelled successfully.'
    );
}

// Complete Appointment
public function completeAppointment($id)
{
    // Lấy bác sĩ đang đăng nhập
    $doctor = Doctor::findOrFail(
        session('doctor_id')
    );

    // Lấy lịch hẹn thuộc bác sĩ này
    $appointment = Appointment::where(
        'AppointmentId',
        $id
    )
        ->where(
            'DoctorId',
            $doctor->DoctorId
        )
        ->firstOrFail();

    // Chỉ lịch Confirmed mới được đánh dấu đã khám
    if ($appointment->Status !== 'Confirmed') {
        return back()->with(
            'error',
            'This appointment cannot be marked as completed.'
        );
    }

    // Chuyển trạng thái sang Completed
    $appointment->Status = 'Completed';

    // Lưu thay đổi
    $appointment->save();

    // Quay lại trang và báo thành công
    return back()->with(
        'success',
        'Appointment marked as completed.'
    );
}
}