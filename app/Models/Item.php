<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'quantity', 'qrcode', 'items_list_id'];

    public function itemsList()
    {
        return $this->belongsTo(Items_list::class);
    }
}
