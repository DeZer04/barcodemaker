<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class origin extends Model
{
    protected $fillable = [
        'name_origin',
        'kode_origin'
    ];

    public function item()
    {
        return $this->hasMany(item::class);
    }

    protected $casts = [
        'kode_origin' => 'array',
    ];
}
