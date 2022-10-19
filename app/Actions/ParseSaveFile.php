<?php

namespace App\Actions;

use App\Enums\ItemRarity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class ParseSaveFile
{
    public array $words = [
        'quest_list',
        'temple_data',
        'weapon_equip',
        'corrupted_slorm',
        'pure_slorm',
        'stats_fetched',
        'level_cap_previous',
        'version',
        'reaper_affinity',
        'temple_upgrades',
        'update_refund',
        'slormite_list',
        'shared_inventory',
        'first_hero',
        'weapon_data',
        'gamemode',
        'skill_equip',
        'hero',
        'missions',
        'temple_blessing',
        'date',
        'store_refresh_list',
        'traits',
        'reputation',
        'wrath',
        'skill_rank',
        'reaper_pity',
        'reaper_runes',
        'gold',
        'xp',
        'mission_match',
        'inventory',
        'slorm',
        'influence',
        'element_equip',
        'tutorials',
        'ultimatums',
        'equipment_list',
        'filter',
        'element_rank',
        'enemy_match',
        'auras',
        'profile',
        'enemy_level',
    ];

    /**
     * Parse the given save file.
     *
     * @param  UploadedFile $file
     * @return array
     */
    public function execute(UploadedFile $file): array
    {
        [$content, $hash] = str($file->getContent())->explode('#');

        $data = $this->parseKeys($content);

        $data['levels'] = str($data['xp'])->explode('|')->map(function ($xp) {
            return $this->getLevelByXP($xp);
        });

        $data['items'] = $this->parseItems($data['inventory']);

        return $data;
    }
    
    /**
     * Return the save file data keyed by human-readable words.
     *
     * @param  string $content
     * @return array
     */
    private function parseKeys(string $content): array
    {
        $content = str($content)->lower();

        $keys = [];

        foreach ($this->words as $index => $word) {
            $firstWord = unpack('H*', $this->words[$index])[1];

            $isAnotherWord = !empty($this->words[$index + 1]);

            if ($isAnotherWord) {
                $nextWord = unpack('H*', $this->words[$index + 1])[1];
                $data = hex2bin($content->betweenFirst($firstWord, $nextWord));
            } else {
                $data = hex2bin($content->after($firstWord));
            }

            $keys[$word] = str($data)
                ->trim()
                ->matchAll('/[a-zA-Z0-9|.?;:-]/')
                ->join('');

            /**
             * Remove the save file content we've already read to avoid duplicates.
             * For example, hero and first_hero or weapon_equip and weapon_data.
             */
            $content = $content->after($firstWord);
        }

        return $keys;
    }

    protected function getLevelByXP(int $xp): int
    {
        $xpAmounts = config('xp_amounts');

        $level = 1;

        foreach ($xpAmounts as $nextLevel) {
            if ($xp >= $nextLevel) {
                $level++;
            } else {
                return $level;
            }
        }

        return $level;
    }

    protected function parseItems(string $inventory): array
    {
        [
            $warriorInventory,
            $huntressInventory,
            $mageInventory,
        ] = str($inventory)->explode('|');

        $warriorItems = str($warriorInventory)
            ->explode(';')
            ->filter(function ($item) {
                return $this->isEquipable($item);
            })
            ->map(function ($item) {
                return $this->parseItem($item);
            })
            ->toArray();

        $huntressItems = str($huntressInventory)
            ->explode(';')
            ->filter(function ($item) {
                return $this->isEquipable($item);
            })
            ->map(function ($item) {
                return $this->parseItem($item);
            })
            ->toArray();

        $mageItems = str($mageInventory)
            ->explode(';')
            ->filter(function ($item) {
                return $this->isEquipable($item);
            })
            ->map(function ($item) {
                return $this->parseItem($item);
            })
            ->toArray();

        return [
            $warriorItems, 
            $huntressItems, 
            $mageItems,
        ];
    }

    protected function parseItem(string $item): array
    {
        $base = str($item)->before(':');
        $bonuses = str($item)->after(':')->explode(':');

        $generic = str($base)->explode('-')->first();

        $data = str($generic)->explode('.');

        $affixes = $bonuses
            ->filter(function ($bonus) {
                return $this->isAffix($bonus);
            })
            ->map(function ($affix) {
                return $this->parseAffix($affix);
            });

        $rarity = $this->getRarityFromAffixes($affixes);

        $parsedItem = [
            'type' => $data[1],
            'level' => $data[2],
            'reinforcement' => $data[5],
            'rarity' => $rarity,
        ];

        return $parsedItem;
    }

    protected function parseResource()
    {

    }

    protected function isEquipable(string $item): bool
    {
        return !str($item)->startsWith('0') && str($item)->length() > 1;
    }

    protected function isAffix(string $bonus): bool
    {
        $values = str($bonus)->explode('.')->count();

        return in_array($values, [4, 5, 6]);
    }

    protected function parseAffix(string $affix): array
    {
        [
            $rarity, 
        ] = str($affix)->explode('.');

        return [
            'rarity' => $rarity,
        ];
    }

    protected function getRarityFromAffixes(Collection $affixes): ItemRarity
    {
        $rarities = $affixes->pluck('rarity');

        if ($rarities->contains('L')) {
            return ItemRarity::LEGENDARY;
        }

        if ($rarities->contains('E')) {
            return ItemRarity::EPIC;
        }

        if ($rarities->contains('R')) {
            return ItemRarity::RARE;
        }

        if ($rarities->contains('M')) {
            return ItemRarity::MAGIC;
        }

        return ItemRarity::NORMAL;
    }
}