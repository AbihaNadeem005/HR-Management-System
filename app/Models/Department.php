<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'rwd';

    public function employees()
    {
        return $this->hasMany(Employee::class, 'Emp_ID'); // Adjust FK if needed
    }
}
