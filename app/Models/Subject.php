<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = [
        'subjectCode',
        'sectionCode',
        'description',
        'units',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'subject_id');
    }
}
