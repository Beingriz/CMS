<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryDB extends Model
{
    use HasFactory;    protected $connection = 'mysql';

    public $table = 'enquiry_form';
}
