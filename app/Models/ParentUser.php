<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentUser extends Model
{
    use HasFactory;
    
    protected $table = 'parents';
    
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
