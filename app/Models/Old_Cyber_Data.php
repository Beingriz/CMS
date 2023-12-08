<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Old_Cyber_Data extends Model
{
    use HasFactory;    protected $connection = 'mysql';

    public $table = 'old_digital_cyber_db';
}
