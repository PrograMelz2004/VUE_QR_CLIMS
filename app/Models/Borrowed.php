<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowed extends Model
{
    use HasFactory;

    protected $table = 'borrowed';

    protected $fillable = [
        'borrower',
        'item_id',
        'quantity',
        'borrowed_date',
    ];

    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
