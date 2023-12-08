<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanCard extends Model
{
    use HasFactory;    protected $connection = 'mysql';

    public $table='pan_card';
    public $timestamps=false;
}
