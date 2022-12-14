<?php

namespace App\Models;

use App\Enums\ItemRarity;
use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => ItemType::class,
        'rarity' => ItemRarity::class,
    ];

    public function affixes(): HasMany
    {
        return $this->hasMany(Affix::class);
    }
}
