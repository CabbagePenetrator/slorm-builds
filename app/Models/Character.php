<?php

namespace App\Models;

use App\Enums\CharacterClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => CharacterClass::class,
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
