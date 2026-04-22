<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    //
    protected $fillable = [
        'pic',
        'jalan',
        'latitude',
        'longitude',
        'priority',
        'status',
        'label_id',
        'desc'
    ];

    protected $with = [
        'label'
    ];

    public function label() : BelongsTo {
        // return $this->belongsTo(Label::class, 'id');
        return $this->belongsTo(Label::class, 'label_id');
    }
}
