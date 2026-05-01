<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $table = 'leave_balances';

    protected $primaryKey = 'employee_id'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'Name',
        'Work_Location',
        'casual_total',
        'sick_total',
        'annual_total',
        'casual_used',
        'sick_used',
        'annual_used',
        'total_allocated',
        'total_leaves',
        'used_leaves',
        'remaining_leaves',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'Emp_ID');
    }
}
