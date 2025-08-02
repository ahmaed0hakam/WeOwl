<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'first_name',
        'last_name',
        'class_id',
        'class_name',
        'section_id',
        'section',
        'deleted'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // Scopes
    public function scopeUnassigned($query)
    {
        return $query->whereNull('class_id');
    }

    public function scopeAssigned($query)
    {
        return $query->whereNotNull('class_id');
    }

    public function scopeActive($query)
    {
        return $query->where('deleted', false);
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(ParentUser::class, 'parent_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusAttribute()
    {
        return $this->class_id ? 'Assigned' : 'Unassigned';
    }
}
