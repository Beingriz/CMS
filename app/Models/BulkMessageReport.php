<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkMessageReport extends Model
{
    use HasFactory;
    public $table = 'bulk_message_report';
    protected $fillable = [
        'template_sid',
        'service',
        'service_type',
        'total_recipients',
        'successful_sends',
        'marketing_cost',
    ];

    public function template()
    {
        return $this->belongsTo(Templates::class);
    }
}
