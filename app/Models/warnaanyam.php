<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class warnaanyam extends Model
{
    protected $fillable = [
        'jenisanyam_id',
        'name_warnaanyam'
    ];

    public function item()
    {
        return $this->hasMany(item::class);
    }

    public function jenisanyam()
    {
        return $this->belongsTo(jenisanyam::class);
    }


}
