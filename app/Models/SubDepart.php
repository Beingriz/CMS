<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDepart extends Model
{
    use HasFactory;
    public $table="sub_depart";    protected $connection = 'mysql';

    public $timestamps=false;
}
