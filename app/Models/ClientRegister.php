<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRegister extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    public $table = "client_register";
    protected $fillable = [
        'Id',
        'Branch_Id',
        'Emp_Id',
        'Name',
        'Relative_Name',
        'Gender',
        'Dob',
        'Email_Id',
        'Mobile_No',
        'Address',
        'Profile_Image',
        'Client_Type',
    ];

    public function applications()
{
    return $this->hasMany(Application::class, 'Client_Id', 'Id');
}
}
