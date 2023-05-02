<?php

namespace App\Models;

class Student extends User
{
    protected static function booted()
    {
        static::addGlobalScope(new Scopes\StudentScope);
    }
}
