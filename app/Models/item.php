<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $fillable = [
        'name_item',
        'grade_id',
        'finishing_id',
        'jenisanyam_id',
        'warnaanyam_id'
    ];

    public function grade()
    {
        return $this->belongsTo(grade::class);
    }

    public function finishing()
    {
        return $this->belongsTo(Finishing::class);
    }

    public function jenisanyam()
    {
        return $this->belongsTo(jenisanyam::class);
    }

    public function warnaanyam()
    {
        return $this->belongsTo(warnaanyam::class);
    }

}
