<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'branch_id',
        'department_id',
        'designation_id',
        'name',
        'email',
        'contact',
        'date_of_birth',
        'date_of_joining',
        'is_user_created',
        'status',
    ];
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->select('id', 'title');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('id', 'title');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id')->select('id', 'title');
    }
}
