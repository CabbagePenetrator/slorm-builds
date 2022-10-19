<?php

namespace App\Actions;

use App\Models\Save;
use App\Enums\CharacterClass;
use App\Actions\ParseSaveFile;
use App\Models\Item;
use Illuminate\Http\UploadedFile;

class StoreSave
{
    public function __construct(
        public ParseSaveFile $parseSaveFileAction
    ) {}

    public function execute(UploadedFile $file): Save
    {
        $data = $this->parseSaveFileAction->execute($file);

        $save = Save::query()->create([
            'version' => $data['version'],
        ]);

        [
            $warriorLevel, 
            $huntressLevel, 
            $mageLevel
        ] = $data['levels'];

        [
            $warriorItems,
            $huntressItems,
            $mageItems
        ] = $data['items'];

        $warrior = $save->characters()->create([
            'type' => CharacterClass::WARRIOR,
            'level' => $warriorLevel,
        ]);

        $save->inventories()->create([
            'character_id' => $warrior->id,
            'is_stash' => false,
        ]);

        $huntress = $save->characters()->create([
            'type' => CharacterClass::HUNTRESS,
            'level' => $huntressLevel,
        ]);

        $save->inventories()->create([
            'character_id' => $huntress->id,
            'is_stash' => false,
        ]);

        $mage = $save->characters()->create([
            'type' => CharacterClass::MAGE,
            'level' => $mageLevel,
        ]);

        $save->inventories()->create([
            'character_id' => $mage->id,
            'is_stash' => false,
        ]);

        $save->inventories()->createMany([
            [
                'is_stash' => true,
            ],
            [
                'is_stash' => true,
            ],
            [
                'is_stash' => true,
            ],
            [
                'is_stash' => true,
            ],
        ]);

        $warrior->items()->createMany(
            collect($warriorItems)->pluck('item')
        );

        $huntress->items()->createMany(
            collect($huntressItems)->pluck('item')
        );

        collect($mageItems)->each(function ($mageItem) use ($mage) {
            $item = $mage->items()->create(
                $mageItem['item']
            );

            $item->affixes()->createMany(
                $mageItem['affixes']
            );
        });

        return $save;
    }
}