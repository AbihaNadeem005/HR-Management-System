<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    // Explicitly specify the table name in the database
    protected $table = 'leave_types'; // <- THIS is key
}
