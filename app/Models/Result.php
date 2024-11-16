<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class Result extends Model
{
    use HasFactory;
    protected $fillable = [
        'target_id',
        'keyword',
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
