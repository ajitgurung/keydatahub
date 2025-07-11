<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\Make;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function view()
    {
        $makes = Make::all();
        return view('user-dashboard', compact('makes'));
    }

    public function info($yearId)
    {
        $info = Info::where('year_id', $yearId)->first();

        if (!$info) {
            return response()->json([]);
        }

        $section = json_decode($info->info, true);
        return response()->json([
            'sections' => $section,
            'image_url' => $info->image ? asset('storage/' . $info->image) : null
        ]);
    }
}
