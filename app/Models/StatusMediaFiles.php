<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMediaFiles extends Model
{
    use HasFactory;
    protected $table = 'status_media_files';

    public function mainServices()
    {
        return $this->belongsTo(MainServices::class);
    }

    public function subService()
    {
        return $this->belongsTo(SubServices::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
