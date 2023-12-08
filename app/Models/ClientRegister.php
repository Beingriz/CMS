<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRegister extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    public $table = "client_register";
}
