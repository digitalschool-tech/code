<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_id'
    ];

    public function course(){
        return $this->belongsTo(course::class);
    }

    public function levels(){
        return $this->hasMany(level::class);
    }
}
