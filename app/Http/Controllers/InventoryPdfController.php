<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Item;
use App\Models\User;
use App\Models\Borrowed;

class InventoryPdfController extends Controller
{
    public function generateItemPdf()
    {
        $inventoryItems = Item::orderBy('created_at', 'desc')->get();

        foreach($inventoryItems as $item){
            $borrowedCount = Borrowed::where('item_id', $item->id)->sum('quantity');
            $item->borrowed = $borrowedCount;
        }

        $data = [
            'inventoryItems' => $inventoryItems,
            'dateGenerated' => now()->format('F j, Y h:i A'),
        ];

        $pdf = Pdf::loadView('pdf.inventory', $data);
        return $pdf->download('Inventory_Report_' . now()->format('Y-m-d') . '.pdf');
    }

    public function generateUserPdf()
    {
        $RegUsers = User::orderBy('created_at', 'desc')->get();

        $data = [
            'RegUsers' => $RegUsers,
            'dateGenerated' => now()->format('F j, Y h:i A'),
        ];

        $pdf = Pdf::loadView('pdf.user', $data);
        return $pdf->download('User_List_' . now()->format('Y-m-d') . '.pdf');
    }
}
