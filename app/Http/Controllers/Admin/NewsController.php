<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    // 1. Xem danh sách bài viết dạng Card Grid
    public function index()
    {
        $newsList = DB::table('News')
            ->leftJoin('AccountUser', 'News.UserId', '=', 'AccountUser.UserId')
            ->leftJoin('Doctor', 'News.DoctorId', '=', 'Doctor.DoctorId')
            ->whereNull('News.DeletedAt')
            ->select(
                'News.*',
                DB::raw("CASE 
                    WHEN News.AuthorType = 'Admin' THEN AccountUser.FullName 
                    WHEN News.AuthorType = 'Doctor' THEN Doctor.FullName 
                    ELSE 'Admin' 
                END as AuthorName")
            )
            ->orderBy('NewsId', 'desc')
            ->paginate(6); // Hiển thị 6 bài/trang theo dạng Grid 3 cột

        return view('admin.news.index', compact('newsList'));
    }

    // 2. Trang xem chi tiết bài viết
    public function show($id)
    {
        $news = DB::table('News')
            ->leftJoin('AccountUser', 'News.UserId', '=', 'AccountUser.UserId')
            ->leftJoin('Doctor', 'News.DoctorId', '=', 'Doctor.DoctorId')
            ->where('News.NewsId', $id)
            ->whereNull('News.DeletedAt')
            ->select(
                'News.*',
                DB::raw("CASE 
                    WHEN News.AuthorType = 'Admin' THEN AccountUser.FullName 
                    WHEN News.AuthorType = 'Doctor' THEN Doctor.FullName 
                    ELSE 'Admin' 
                END as AuthorName")
            )
            ->first();

        if (!$news) {
            return redirect()->route('admin.news.index')->with('error', 'Post not found!');
        }

        return view('admin.news.show', compact('news'));
    }

    // 3. Hiển thị form đăng bài viết mới
    public function create()
    {
        return view('admin.news.create');
    }

    // 4. Xử lý lưu bài viết mới
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:300',
            'category'     => 'nullable|string|max:100',
            'content'      => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $thumbnailUrl = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Cấu trúc: time() + tên chung + uniqid() để tránh trùng tuyệt đối khi up cùng lúc
            $fileName = time() . '_news_thumbnail_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/thumbnails');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);
            $thumbnailUrl = '/uploads/thumbnails/' . $fileName;
        }

        DB::table('News')->insert([
            'Title'        => $request->input('title'),
            'Category'     => $request->input('category'),
            'Content'      => $request->input('content'),
            'ThumbnailUrl' => $thumbnailUrl,
            'AuthorType'   => 'Admin',
            'UserId'       => Auth::id(),
            'DoctorId'     => null,
            'IsPublished'  => $request->has('is_published') ? 1 : 0,
            'PublishedAt'  => now(),
            'CreatedAt'    => now(),
            'UpdatedAt'    => now(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Create new post successfully!');
    }

    // 5. Form chỉnh sửa
    public function edit($id)
    {
        $news = DB::table('News')
            ->where('NewsId', $id)
            ->whereNull('DeletedAt')
            ->first();

        if (!$news) {
            return redirect()->route('admin.news.index')->with('error', 'Post not found!');
        }

        return view('admin.news.edit', compact('news'));
    }

    // 6. Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required|string|max:300',
            'category'     => 'nullable|string|max:100',
            'content'      => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $news = DB::table('News')
            ->where('NewsId', $id)
            ->whereNull('DeletedAt')
            ->first();

        if (!$news) {
            return redirect()->route('admin.news.index')->with('error', 'Post not found!');
        }

        $thumbnailUrl = $news->ThumbnailUrl;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Cấu trúc: time() + tên chung + uniqid()
            $fileName = time() . '_news_thumbnail_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/thumbnails');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Xóa file ảnh cũ nếu tồn tại trong thư mục uploads/thumbnails
            if ($news->ThumbnailUrl && File::exists(public_path($news->ThumbnailUrl))) {
                File::delete(public_path($news->ThumbnailUrl));
            }

            $file->move($destinationPath, $fileName);
            $thumbnailUrl = '/uploads/thumbnails/' . $fileName;
        }

        DB::table('News')
            ->where('NewsId', $id)
            ->update([
                'Title'        => $request->input('title'),
                'Category'     => $request->input('category'),
                'Content'      => $request->input('content'),
                'ThumbnailUrl' => $thumbnailUrl,
                'IsPublished'  => $request->has('is_published') ? 1 : 0,
                'UpdatedAt'    => now(),
            ]);

        return redirect()->route('admin.news.index')->with('success', 'Update post successfully!');
    }

    // 7. Xóa bài viết
    public function destroy($id)
    {
        DB::table('News')
            ->where('NewsId', $id)
            ->update(['DeletedAt' => now()]);

        return redirect()->route('admin.news.index')->with('success', 'Delete post successfully!');
    }
}
