<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistedContact extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'mobile_no', 'reason'];

    // Relationship to ClientRegister model
    public function client()
    {
        return $this->belongsTo(ClientRegister::class, 'client_id');
    }
}
