<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    // Hiển thị form viết bài mới
    public function create()
    {
        return view('admin.blogs.create');
    }

    // Xử lý lưu bài viết vào bảng Content
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:300',
            'category' => 'nullable|string|max:50',
            'content'  => 'required|string',
        ]);

        // Thêm dữ liệu bài viết vào DB
        DB::table('Content')->insert([
            'Title'       => $request->input('title'),
            'Category'    => $request->input('category'),
            'Body'        => $request->input('content'),
            'PublishedBy' => null, // FK tới DoctorId, Admin đăng bài sẽ giữ null
            'PublishedAt' => now(),
        ]);

        return redirect()->back()->with('success', 'Blog published successfully!');
    }
}
