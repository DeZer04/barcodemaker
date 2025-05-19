<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'containerindex',
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
