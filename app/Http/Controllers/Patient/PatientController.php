<?php

namespace App\Http\Controllers\Patient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\City;
use App\Models\News;


class PatientController extends Controller
{
    public function index(): View
    {
        return view('patient.index');
    }

    public function about(): View
    {
        return view('patient.about');
    }

    public function service(): View
    {
        return view('patient.service');
    }

    public function specialization()
    {
        // Lấy tất cả chuyên khoa từ Database
        $specializations = Specialization::all();

        // Trả về view danh sách (Đổi tên path view cho đúng với file của bạn)
        return view('patient.specialization', compact('specializations'));
    }

    public function specializationSingle($id)
    {
        // 1. Tìm chuyên khoa theo ID (tương thích với cả SpecializationId hoặc id)
        $specialization = Specialization::where('SpecializationId', $id)
            ->orWhere('SpecializationId', $id)
            ->firstOrFail();

        // 2. Lấy danh sách các chuyên khoa khác hiển thị ở Sidebar (trừ trang hiện tại)
        $primaryKey = $specialization->SpecializationId ? 'SpecializationId' : 'id';
        $otherSpecializations = Specialization::where($primaryKey, '!=', $specialization->$primaryKey)
            ->take(5)
            ->get();

        // 3. Trả về view chi tiết
        return view('patient.specialization-single', compact('specialization', 'otherSpecializations'));
    }


    public function appointment(): View
    {
        return view('patient.appointment');
    }

    public function confirmation(): View
    {
        return view('patient.confirmation');
    }

    // Hiển thị trang News (blog cũ)
    public function blogSidebar(Request $request)
    {
        $query = News::query();

        // Lấy từ khóa từ input
        if ($request->filled('keyword')) {
            $keyword = trim($request->input('keyword'));
            $query->where(function ($q) use ($keyword) {
                $q->where('Title', 'like', "%{$keyword}%")
                    ->orWhere('Category', 'like', "%{$keyword}%")
                    ->orWhere('Content', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('Category', $request->category);
        }

        $news = $query->orderBy('PublishedAt', 'desc')->paginate(5);

        // Trả về JSON cho request AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('patient.blog-news-list', compact('news'))->render()
            ]);
        }

        $popularNews = News::orderBy('PublishedAt', 'desc')->take(3)->get();
        $categories = News::select('Category')
            ->selectRaw('COUNT(*) as news_count')
            ->whereNotNull('Category')
            ->groupBy('Category')
            ->get();

        return view('patient.blog-sidebar', compact('news', 'popularNews', 'categories'));
    }

    // Hiển thị newsSingle (blog-Single cũ)
    public function blogSingle($id)
    {
        // Tìm bài viết theo NewsId hoặc id
        $news = News::where('NewsId', $id)
            ->orWhere('NewsId', $id)
            ->firstOrFail();

        // Lấy danh sách các bài viết mới nhất khác cho Sidebar (trừ bài hiện tại)
        $recentNews = News::where($news->getKeyName(), '!=', $news->getKey())
            ->latest()
            ->take(5)
            ->get();

        // Trả về view chi tiết bài viết
        return view('patient.blog-single', compact('news', 'recentNews'));
    }

    // Hiển thị trang contact
    public function contact(): View
    {
        return view('patient.contact');
    }
    
    // Xử lý lưu form vào DB


    /**
     * Hiển thị trang chi tiết chuyên khoa động dựa vào tên chuyên khoa
     */
    // public function specializationSingle(string $slug)
    // {
    //     // Chuẩn hóa tên view (Ví dụ: cardiology -> Cardiology)
    //     $formattedName = ucfirst($slug);
    //     $viewPath = "patient.specializations-single.{$formattedName}";

    //     // Kiểm tra nếu view tồn tại thì render, ngược lại trả về 404
    //     if (view()->exists($viewPath)) {
    //         return view($viewPath);
    //     }

    //     abort(404);
    // }

    // Hiển thị danh sách doctor
    public function Doctor(Request $request)
    {
        $query = Doctor::with(['specialization', 'city']);

        // Tìm kiếm theo tên
        if ($request->filled('keyword')) {
            $query->where('FullName', 'like', '%' . $request->keyword . '%');
        }

        // Lọc theo Thành phố
        if ($request->filled('city_id')) {
            $query->where('CityId', $request->city_id);
        }

        // Lọc theo Chuyên khoa
        if ($request->filled('specialization_id')) {
            $query->where('SpecializationId', $request->specialization_id);
        }

        $doctors = $query->get();

        // Nếu là request AJAX thì chỉ trả về danh sách thẻ bác sĩ
        if ($request->ajax()) {
            return view('patient.doctors-list', compact('doctors'))->render();
        }

        $specializations = Specialization::all();
        $cities = City::all();

        return view('patient.doctor', compact('doctors', 'specializations', 'cities'));
    }
}
