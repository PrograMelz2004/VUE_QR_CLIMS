<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Items_list;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowed;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function index()
    {
        $items_lists = Items_list::with('items')->get();
        return view('admin.items', compact('items_lists'), ['user' => Auth::user()]);
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
            $borrowedCount = Borrowed::where('item_id', $item->id)->sum('quantity');

            $item->borrowed = $borrowedCount;
    
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
    
    public function add(Request $request)
    {
        Items_list::create($request->all());
        return response()->json(['success' => true]);
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
            'room_id' => 'required',
            'borrower_name' => 'required|string',
        ]);

        $item = Item::where('name', $request->name)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        if ($item->quantity < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough quantity available.']);
        }

        $res = Borrowed::create([
            'borrower' => $request->borrower_name,
            'item_id' => $item->id,
            'room_id' => $request->room_id,
            'quantity' => $request->quantity,
            'borrowed_date' => Carbon::now(),
        ]);

        if ($res) {
            $item->quantity -= $request->quantity;
            $item->save();

            return response()->json(['success' => true]);
        }
    }

    public function return(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer|min:1',
        ]);

        $item = Item::where('id', $request->item_id)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        Borrowed::where('item_id', $item->id)->delete();

        $item->quantity = 1;
        $item->save();

        return response()->json(['success' => true, 'message' => 'Item returned successfully.']);
    }

    public function codes(Request $request)
    {
        $search = $request->input('search');
    
        $items = DB::table('items')
            ->when($search, function ($query, $search) {
                $query->where('qrcode', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
            })
            ->limit(20)
            ->get(['qrcode', 'name']);
    
        $results = $items->map(function ($item) {
            return [
                'id' => $item->qrcode,
                'text' => $item->name . ' - ' . $item->qrcode
            ];
        })->toArray();
    
        return response()->json($results);
    }
}
