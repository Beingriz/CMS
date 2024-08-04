<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRegister extends Model
{
    use HasFactory;

    protected $table = 'employee_register';

    protected $primaryKey = 'Id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'Id',
        'Emp_Id',
        'Branch_Id',
        'Name',
        'DOB',
        'Father_Name',
        'Mobile_No',
        'Address',
        'Gender',
        'Email_Id',
        'Experience',
        'Qualification',
        'Branch',
        'Role',
        'Profile_Img',
        'Qualification_Doc',
        'Resume_Doc'
    ];

    public function scopeFilter($query, $key)
    {
        $key = "%$key%";
        $query->where(function ($query) use ($key) {
            $query->where('Name', 'Like', $key)
                ->orWhere('Mobile_No', 'Like', $key)
                ->orWhere('Email_Id', 'Like', $key)
                ->orWhere('Branch', 'Like', $key)
                ->orWhere('Id', 'Like', $key)
                ->orWhere('Emp_Id', 'Like', $key);

        });
    }

    // /**
    //  * Define the relationship with the Branches model.
    //  */
    // public function branch()
    // {
    //     return $this->belongsTo(Branches::class, 'Branch_Id', 'branch_id');
    // }

    // /**
    //  * Define the relationship with the User model.
    //  * Assuming each employee is also a user in your system.
    //  */
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'Emp_Id', 'Emp_Id');
    // }
}
