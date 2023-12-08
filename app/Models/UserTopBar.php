<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTopBar extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public $table = 'user_top_bar';
}
