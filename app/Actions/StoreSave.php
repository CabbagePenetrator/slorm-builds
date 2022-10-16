<?php

namespace App\Actions;

use App\Models\Save;
use App\Enums\CharacterClass;
use App\Actions\ParseSaveFile;
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

        return $save;
    }
}