<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finishing extends Model
{
    protected $fillable = [
        'name_finishing'
    ];

    public function item()
    {
        return $this->hasMany(item::class);
    }
}
