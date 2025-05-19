<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase extends Model
{
    Use HasFactory;

    protected $fillable = [
        'buyer_id',
        'purchaseindex'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function containers()
    {
        return $this->hasMany(Container::class);
    }
}
