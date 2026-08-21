<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Danh sách tất cả các yêu cầu liên hệ (Hỗ trợ lọc theo Pending / Resolved)
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'All');

        $query = ContactQuery::orderBy('SubmittedAt', 'desc');

        if ($status !== 'All') {
            $query->where('Status', $status);
        }

        $queries = $query->paginate(10)->withQueryString();

        // Thống kê số lượng theo 2 trạng thái
        $counts = [
            'All'      => ContactQuery::count(),
            'Pending'  => ContactQuery::where('Status', 'Pending')->count(),
            'Resolved' => ContactQuery::where('Status', 'Resolved')->count(),
        ];

        return view('admin.contact.index', compact('queries', 'status', 'counts'));
    }

    /**
     * Xem chi tiết câu hỏi & form phản hồi
     */
    public function show($id)
    {
        $query = ContactQuery::with('respondedByAdmin')->findOrFail($id);
        return view('admin.contact.show', compact('query'));
    }

    /**
     * Lưu thông tin phản hồi của Admin & Gửi Mail cho Bệnh nhân
     */
    public function respond(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string|min:5',
        ], [
            'admin_notes.required' => 'Please enter your response message.',
            'admin_notes.min'      => 'Response content must be at least 5 characters.',
        ]);

        $query = ContactQuery::findOrFail($id);
        $adminNotes = $request->input('admin_notes');

        // 1. Cập nhật trạng thái và nội dung trả lời trong CSDL
        $query->update([
            'AdminNotes'  => $adminNotes,
            'Status'      => 'Resolved',
            'RespondedBy' => Auth::id(),
            'RespondedAt' => now(),
        ]);

        // 2. Gửi Email phản hồi cho Bệnh nhân
        try {
            Mail::send([], [], function ($message) use ($query, $adminNotes) {
                $message->to($query->Email, $query->SenderName)
                    ->subject('MediConnect - Response to your inquiry: ' . ($query->Subject ?? 'Contact Support'))
                    ->html("
                            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;'>
                                <h2 style='color: #2563eb; margin-top: 0;'>MediConnect Medical Center</h2>
                                <p>Dear <strong>{$query->SenderName}</strong>,</p>
                                <p>Thank you for contacting us. Here is our response to your inquiry regarding <em>\"" . e($query->Subject) . "\"</em>:</p>
                                <div style='background-color: #f8fafc; padding: 15px; border-left: 4px solid #2563eb; margin: 15px 0; border-radius: 4px;'>
                                    " . nl2br(e($adminNotes)) . "
                                </div>
                                <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>
                                <p style='font-size: 13px; color: #64748b;'>If you have any further questions, please feel free to reply directly to this email.</p>
                                <p style='font-size: 13px; color: #64748b; margin-bottom: 0;'>Best regards,<br><strong>MediConnect Support Team</strong></p>
                            </div>
                        ");
            });

            return redirect()->route('admin.contact.index')
                ->with('success', 'Response saved and email sent successfully!');
        } catch (\Exception $e) {
            // Trường hợp cấu hình MAIL trong .env chưa sẵn sàng, dữ liệu vẫn được ghi nhận vào CSDL
            return redirect()->route('admin.contact.index')
                ->with('success', 'Response recorded successfully in database! (Mail not sent due to SMTP configuration)');
        }
    }
}
