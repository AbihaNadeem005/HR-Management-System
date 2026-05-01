<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'rwd';
    protected $primaryKey = 'CNIC';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'CNIC',
        'Emp_ID',
        'Name',
        'Father_name',
        'Qualification',
        'Gender',
        'DOB',
        'Religion',
        'Nationality',
        'Domicile',
        'District',
        'Present_Home_Address',
        'Permanent_Home_Address',
        'Phone_no',
        'Email',
        'Date_of_joining',
        'Job_Type',
        'Designation',
        'Department',
        'Starting_Salary',
        'Current_Salary',
        'Work_Location',
        'Source_of_Funding',
        'Date_of_Leaving',
        'Probation_Ending_Date',
        'Final_Settlement'
    ];
}
