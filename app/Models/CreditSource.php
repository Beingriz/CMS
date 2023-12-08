<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditSource extends Model
{
    use HasFactory;    protected $connection = 'mysql';

    public $table="credit_source";
    public $timestamp = false;
}
