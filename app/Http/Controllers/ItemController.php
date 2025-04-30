<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowed;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('admin/items', compact('items'), ['user' => Auth::user()]);
    }

    public function scanner()
    {
        $rooms = DB::table('rooms')->get();
        $items = Item::all();
        $user = Auth::user();
        return view('admin/scan', compact('rooms', 'items', 'user'));
    }

    public function scan(Request $request)
    {
        $scannedCode = $request->input('qrcode');
        $item = Item::where('qrcode', $scannedCode)->first();

        if ($item) {
            return response()->json([
                'success' => true,
                'item' => $item
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'QR Code not found.'
            ]);
        }
    }

    public function store(Request $request)
    {
        Item::create($request->all());
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        Item::findOrFail($id)->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Item::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }


    public function borrow(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'borrower_name' => 'required|string',
        ]);

        $item = Item::where('name', $request->name)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        if ($item->quantity < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough quantity available.']);
        }

        $item->quantity -= $request->quantity;
        $item->save();

        Borrowed::create([
            'borrower' => $request->borrower_name,
            'item_id' => $item->id,
            'quantity' => $request->quantity,
            'borrowed_date' => Carbon::now(),
        ]);

        return response()->json(['success' => true]);
    }
}
