<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lesson_id'
    ];

    public function level(){
        return $this->belongsTo(level::class);
    }
}
