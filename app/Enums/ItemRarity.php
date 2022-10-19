<?php

namespace App\Enums;

enum ItemRarity: int
{
    case NORMAL = 0;
    case MAGIC = 1;
    case RARE = 2;
    case EPIC = 3;
    case LEGENDARY = 4;

    public function name(): string
    {
        return match ($this) {
            ItemRarity::NORMAL => 'normal',
            ItemRarity::MAGIC => 'magic',
            ItemRarity::RARE => 'rare',   
            ItemRarity::EPIC => 'epic',   
            ItemRarity::LEGENDARY => 'legendary',   
        };
    }
}
