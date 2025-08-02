<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'subject',
        'experience_years',
        'qualification',
        'hire_date',
        'phone',
        'address',
        'status'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
    }
}
