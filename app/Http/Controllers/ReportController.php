<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowed;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function view()
    {
        $borrowed = Borrowed::all();

        foreach ($borrowed as $item) {
            $item->item_name = DB::table('items')->where('id', $item->item_id)->value('name') ?? 'N/A';
            $item->room_name = DB::table('rooms')->where('id', $item->room_id)->value('name') ?? 'N/A';
            $item->borrowed_date = Carbon::parse($item->borrowed_date)->format('M. j, Y h:i A');
        }

        return view('admin.reports', compact('borrowed'), ['user' => Auth::user()]);
    }
}
