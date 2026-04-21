<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'pic',
        'jalan',
        'latitude',
        'longitude',
        'priority',
        'status',
        'user_id',
        'desc'
    ];

    protected $with = [
        'reportedBy'
    ];

    public function reportedBy() : BelongsTo {
        return $this->belongsTo(User::class, 'id');
    }
}
