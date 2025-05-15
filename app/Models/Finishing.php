<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\item as Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finishing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_finishing'
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
