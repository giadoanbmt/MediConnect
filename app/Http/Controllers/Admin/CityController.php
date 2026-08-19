<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        // Dùng Eloquent Model City thay vì DB::table để tự động lấy đúng bảng 'City'
        $cities = City::all();

        return view('admin.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'CityName'     => 'required|string|max:255',
            'DistrictName' => 'nullable|string|max:255',
        ], [
            'CityName.required' => 'Please enter the name of the Province/City.',
        ]);

        City::create([
            'CityName'     => trim($request->CityName),
            'DistrictName' => $request->filled('DistrictName') ? trim($request->DistrictName) : null,
        ]);

        return back()->with('success', 'Successfully added Province/City and District!');
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return back()->with('success', 'Successfully deleted!');
    }
}
