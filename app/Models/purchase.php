<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    protected $fillable = [
        'buyer_id',
        'purchase_index'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
