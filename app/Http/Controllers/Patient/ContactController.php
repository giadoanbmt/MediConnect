<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate dữ liệu nhập vào
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required'    => 'Vui lòng nhập họ và tên.',
            'email.required'   => 'Vui lòng nhập email.',
            'email.email'      => 'Định dạng email không hợp lệ.',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
        ]);

        // 2. Lưu vào CSDL
        ContactQuery::create([
            'SenderName'  => $validated['name'],
            'Email'       => $validated['email'],
            'PhoneNumber' => $validated['phone'] ?? null,
            'Subject'     => $validated['subject'] ?? 'Không có tiêu đề',
            'MessageText' => $validated['message'],
            'Status'      => 'Pending', // Trạng thái mặc định
            'SubmittedAt' => now(),      // Do timestamps = false nên gán thời gian hiện tại
        ]);

        // 3. Quay lại và thông báo thành công
        return back()->with('success', 'Gửi tin nhắn liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.');
    }
}
?>