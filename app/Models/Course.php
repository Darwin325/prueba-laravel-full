<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'time', 'start_date', 'end_date'
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, "course_user", "user_id")
            ->withTimestamps();
    }
}
