<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    public function settings()
    {
        $system = DB::table('system')->get();
        $rooms = DB::table('rooms')->get();
        $user = Auth::user();
        return view('admin.settings', compact('system', 'rooms', 'user'));
    }
}