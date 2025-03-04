<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Added role
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $guard = 'web';

    // Check if the user is an admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id'); // assuming 'student_id' is the foreign key in the grades table
    }
    
}

