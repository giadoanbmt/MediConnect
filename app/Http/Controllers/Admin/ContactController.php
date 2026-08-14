<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Danh sách tất cả các liên hệ
    public function index()
    {
        $queries = ContactQuery::orderBy('SubmittedAt', 'desc')->paginate(10);
        return view('admin.contact.index', compact('queries'));
    }

    // Xem chi tiết câu hỏi
    public function show($id)
    {
        $query = ContactQuery::with('respondedByAdmin')->findOrFail($id);
        return view('admin.contact.show', compact('query'));
    }

    // Lưu thông tin phản hồi của Admin
    public function respond(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string',
        ], [
            'admin_notes.required' => 'Please enter the response content.',
        ]);

        $query = ContactQuery::findOrFail($id);
        $adminNotes = $request->input('admin_notes');

        // 1. Cập nhật CSDL
        $query->update([
            'AdminNotes'  => $adminNotes,
            'Status'      => 'Resolved',
            'RespondedBy' => Auth::id(),
            'RespondedAt' => now(),
        ]);

        // 2. Tự động gửi Email phản hồi cho khách hàng
        try {
            Mail::send([], [], function ($message) use ($query, $adminNotes) {
                $message->to($query->Email, $query->SenderName)
                        ->subject('MediConnect - Response to your contact inquiry: ' . $query->Subject)
                        ->html("
                            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                                <h2 style='color: #0d6efd;'>MediConnect Medical Center</h2>
                                <p>Dear <strong>{$query->SenderName}</strong>,</p>
                                <p>Thank you for reaching out to us. Below is the response regarding your inquiry:</p>
                                <hr style='border: none; border-top: 1px solid #eee; margin: 15px 0;'>
                                <div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px;'>
                                    {$adminNotes}
                                </div>
                                <hr style='border: none; border-top: 1px solid #eee; margin: 15px 0;'>
                                <p>If you have further questions, feel free to reply to this email.</p>
                                <p>Best regards,<br><strong>MediConnect Support Team</strong></p>
                            </div>
                        ");
            });

            return redirect()->route('admin.contact.index')
                             ->with('success', 'Response saved and email sent successfully!');

        } catch (\Exception $e) {
            // Nếu lỗi gửi mail (do chưa cấu hình .env) vẫn lưu DB thành công
            return redirect()->route('admin.contact.index')
                             ->with('success', 'Response saved to database! (Note: Could not send email, please check .env MAIL settings)');
        }
    }
}
?>