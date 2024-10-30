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

    public function selector(): HasOne
    {
        return $this->hasOne(Selector::class);
    }

    public function result(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
