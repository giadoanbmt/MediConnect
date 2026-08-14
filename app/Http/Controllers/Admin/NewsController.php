<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    // 1. Xem danh sách tất cả các bài viết trong Database
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
            ->orderBy('NewsId', 'desc') // Bài mới nhất lên đầu
            ->paginate(5);

        return view('admin.news.index', compact('newsList'));
    }

    // 2. Hiển thị form đăng bài viết mới
    public function create()
    {
        return view('admin.news.create');
    }

    // 3. Xử lý lưu bài viết mới vào CSDL
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:300',
            'category'     => 'nullable|string|max:100',
            'content'      => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Nhận name="image" từ Blade, cho phép null
            'is_published' => 'nullable|boolean',
        ]);

        // Xử lý upload file ảnh (Nếu không chọn ảnh thì $thumbnailUrl = null)
        $thumbnailUrl = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $thumbnailUrl = '/storage/' . $path;
        }

        DB::table('News')->insert([
            'Title'        => $request->input('title'),
            'Category'     => $request->input('category'),
            'Content'      => $request->input('content'),
            'ThumbnailUrl' => $thumbnailUrl, // Lưu đường dẫn hoặc NULL vào cột ThumbnailUrl
            'AuthorType'   => 'Admin',
            'UserId'       => Auth::id(), // ID của Admin đang tạo bài
            'DoctorId'     => null,
            'IsPublished'  => $request->has('is_published') ? 1 : 0,
            'PublishedAt'  => now(),
            'CreatedAt'    => now(),
            'UpdatedAt'    => now(),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Create new post successfully!');
    }

    // 4. Hiển thị form chỉnh sửa bài viết
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

    // 5. Cập nhật thông tin bài viết
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

        // Mặc định giữ lại đường dẫn ảnh cũ
        $thumbnailUrl = $news->ThumbnailUrl;

        // Nếu người dùng chọn ảnh mới thì upload và đè đường dẫn
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $thumbnailUrl = '/storage/' . $path;
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

    // 6. Xóa bài viết (Thực hiện Soft Delete)
    public function destroy($id)
    {
        DB::table('News')
            ->where('NewsId', $id)
            ->update(['DeletedAt' => now()]);

        return redirect()->route('admin.news.index')->with('success', 'Delete post successfully!');
    }
}
