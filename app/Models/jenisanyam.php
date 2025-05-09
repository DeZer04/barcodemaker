<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jenisanyam extends Model
{
    protected $fillable = [
        'name_jenisanyam'
    ];

    public function item()
    {
        return $this->hasMany(item::class);
    }
}
