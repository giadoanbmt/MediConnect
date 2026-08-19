<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Models\ClinicRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::with('clinicRooms')->get();

        return view('admin.specializations.index', compact('specializations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'SpecializationName' => 'required|string|max:255|unique:Specialization,SpecializationName',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'Description'        => 'nullable|string',
            'Content'            => 'nullable|string',
            'RoomName'           => 'nullable|string|max:255',
            'RoomNumber'         => 'nullable|string|max:50|unique:ClinicRoom,RoomNumber',
            'LocationFloor'      => 'nullable|string|max:50',
        ], [
            'SpecializationName.unique' => 'Name of the specialization already exists in the system.',
            'RoomNumber.unique'         => 'Room number already exists in the system.',
        ]);

        $imageUrl = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = Str::slug($request->SpecializationName) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/specializations');
            $file->move($destinationPath, $fileName);

            $imageUrl = 'uploads/specializations/' . $fileName;
        }

        $specialization = Specialization::create([
            'SpecializationName' => trim($request->SpecializationName),
            'Description'        => $request->Description,
            'Content'            => $request->Content,
            'ImageUrl'           => $imageUrl,
        ]);

        // Tạo phòng khám khởi tạo (Nêu Admin nhập Mã/Số phòng hoặc Tên phòng)
        if ($request->filled('RoomNumber') || $request->filled('RoomName')) {
            ClinicRoom::create([
                'RoomName'         => trim($request->RoomName ?? ('Room ' . $request->RoomNumber)),
                'RoomNumber'       => trim($request->RoomNumber),
                'SpecializationId' => $specialization->SpecializationId,
                'LocationFloor'    => $request->LocationFloor,
                'IsActive'         => true,
            ]);
        }

        return back()->with('success', 'Added specialization and clinic room successfully!');
    }

    public function addRoom(Request $request, $id)
    {
        $request->validate([
            'RoomName'      => 'required|string|max:255',
            'RoomNumber'    => 'required|string|max:50|unique:ClinicRoom,RoomNumber',
            'LocationFloor' => 'nullable|string|max:50',
        ], [
            'RoomName.required'   => 'Please enter the room name.',
            'RoomNumber.required' => 'Please enter the room number.',
            'RoomNumber.unique'   => 'This room number already exists in the system.',
        ]);

        ClinicRoom::create([
            'RoomName'         => trim($request->RoomName),
            'RoomNumber'       => trim($request->RoomNumber),
            'SpecializationId' => $id,
            'LocationFloor'    => $request->LocationFloor,
            'IsActive'         => true,
        ]);

        return back()->with('success', 'Added clinic room successfully!');
    }

    public function destroyRoom($roomId)
    {
        ClinicRoom::where('RoomId', $roomId)->delete();
        return back()->with('success', 'Deleted clinic room successfully!');
    }

    public function destroy($id)
    {
        $specialization = Specialization::findOrFail($id);

        if ($specialization->ImageUrl && File::exists(public_path($specialization->ImageUrl))) {
            File::delete(public_path($specialization->ImageUrl));
        }

        $specialization->clinicRooms()->delete();
        $specialization->delete();

        return back()->with('success', 'Deleted specialization successfully!');
    }
}
