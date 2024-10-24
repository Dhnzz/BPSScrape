<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasOne, HasMany};

class Target extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'keyword'
    ];

    public function detail_target(): HasOne
    {
        return $this->hasOne(DetailTarget::class);
    }

    public function scrape_result(): HasMany
    {
        return $this->hasMany(ScrapeResult::class);
    }
}
