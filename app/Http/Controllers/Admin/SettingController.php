<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Setting::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $settingsData = $request->all();
            foreach ($settingsData as $setting) {
                $value = $setting['value'];
                Setting::updateOrCreate(['id' => $setting['id']], ['value' => $value]);
            }
            return response()->json(['success' => true, 'message' => 'Settings updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 401);
        }
    }


}
