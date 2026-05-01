<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';
    
    protected $primaryKey = 'id';  // default
    public $timestamps = false;    // if you don't have created_at/updated_at

   protected $fillable = [
    'employee_id',
    'employee_name',
    'leave_type',
    'start_date',
    'end_date',
    'status',
    'reason'
];
}
