<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\item as Item;

class grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_grade',
    ];

    // Define relationship to items
    public function items()
    {
        return $this->hasMany(Item::class, 'grade_id');
    }
}
