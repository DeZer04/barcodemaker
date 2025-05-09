<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grade extends Model
{
    protected $fillable = [
        'name_grade'
    ];

    public function item ()
    {
        return $this->hasMany(item::class);
    }
}
