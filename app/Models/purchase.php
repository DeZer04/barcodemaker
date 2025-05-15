<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    Use HasFactory;

    protected $fillable = [
        'buyer_id',
        'purchase_index'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
