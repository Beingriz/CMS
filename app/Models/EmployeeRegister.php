<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRegister extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public $table = 'employee_register';
    protected $fillable = [
        'Id', // Add 'id' to allow mass assignment
        'Emp_Id',
        'Branch_Id',
        'Name',
        'DOB',
        'Mobile_No',
        'Father_Name',
        'Gender',
        'Email_Id',
        'Qualification',
        'Role',
        'Experience',
        'Profile_Img',
        'Resume_Doc',
        'Qualification_Doc',
        'Branch'
        // Add other fields as necessary
    ];
}
