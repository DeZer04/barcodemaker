<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $fillable = [
        'name_item',
        'jeniskayu_id',
        'grade_id',
        'finishing_id',
        'jenisanyam_id',
        'warnaanyam_id'
    ];

    public function jeniskayu()
    {
        return $this->belongsTo(jeniskayu::class);
    }

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
