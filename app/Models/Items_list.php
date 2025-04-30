<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Items_list extends Model
{
    use HasFactory;

    protected $table = 'items_list';

    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
