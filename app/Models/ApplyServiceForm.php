<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyServiceForm extends Model
{
    use HasFactory;
    public $table = 'applynow';
    protected $guard=[];
    protected $connection ='mysql';

}