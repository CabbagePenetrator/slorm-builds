<?php

namespace App\Enums;

enum CharacterClass: int
{
    case WARRIOR = 0;
    case HUNTRESS = 1;
    case MAGE = 2;

    public function name(): string
    {
        return match ($this) {
            CharacterClass::WARRIOR => 'warrior',
            CharacterClass::HUNTRESS => 'huntress',
            CharacterClass::MAGE => 'mage',
        };
    }
}