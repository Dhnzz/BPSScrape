<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class Selector extends Model
{
    use HasFactory;
    protected $fillable = [
        'target_id',
        'headline',
        'date',
        'link',
        'content',
        'cover',
        'tags',
    ];

    public function target(): BelongsTo
    {
        return $this->belongsTo(Target::class);
    }
}
