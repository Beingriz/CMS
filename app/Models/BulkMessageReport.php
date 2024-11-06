<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkMessageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id', 'service','service_type', 'total_recipients', 'successful_sends',
    ];

    public function template()
    {
        return $this->belongsTo(Templates::class);
    }
}
