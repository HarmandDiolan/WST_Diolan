<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'email',
        'age',
    ];

    public function enrollments(){
        return $this->hasMany(Enrollment::class, 'student_id');
    }

}
