<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    public function settings()
    {
        $system = DB::table('system')->first();
        $rooms = DB::table('rooms')->get();
        $user = Auth::user();
        $items = DB::table('items_list')->get();
        return view('admin.settings', compact('system', 'rooms', 'user', 'items'));
    }

    public function addRoom(Request $request)
    {
        $request->validate([
            'room_name' => 'required|string|max:255'
        ]);

        DB::table('rooms')->insert([
            'name' => $request->room_name
        ]);

        return response()->json(['success' => true, 'message' => 'Room added successfully.']);
    }

    public function editRoom(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'room_name' => 'required|string|max:255'
        ]);

        $updated = DB::table('rooms')
            ->where('id', $request->room_id)
            ->update(['name' => $request->room_name]);

        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Room updated successfully.']);
        }

        return response()->json(['error' => 'Room not found or no changes made.'], 404);
    }

    public function deleteRoom(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $deleted = DB::table('rooms')->where('id', $request->id)->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Room deleted successfully.']);
        }

        return response()->json(['error' => 'Room not found.'], 404);
    }

    public function updateSystemNames(Request $request)
    {
        $request->validate([
            'sys_s_name' => 'required|string|max:255',
            'sys_l_name' => 'required|string|max:255'
        ]);

        $updated = DB::table('system')
            ->where('id', '1')
            ->update([
                'sys_s_name' => $request->sys_s_name,
                'sys_l_name' => $request->sys_l_name
            ]);

        if ($updated) {
            return response()->json(['success' => true, 'message' => 'System names updated successfully.']);
        }

        return response()->json(['error' => 'Failed to update system names.'], 500);
    }
}
