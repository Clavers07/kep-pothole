<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Label extends Model
{
    //
    protected $fillable = [
        'name',
        'desc',
        'pic'
    ];

    public function reports() : HasMany {
        return $this->hasMany(Report::class, 'label_id');
    }
}
