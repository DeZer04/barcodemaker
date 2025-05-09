<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jeniskayu extends Model
{
    protected $fillable = [
        'name_jeniskayu'
    ];

    public function item()
    {
        return $this->hasMany(item::class);
    }
}
