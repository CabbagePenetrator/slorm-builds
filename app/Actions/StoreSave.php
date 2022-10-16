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

        $save->characters()->create([
            'type' => CharacterClass::WARRIOR,
            'level' => $warriorLevel,
        ]);

        $save->characters()->create([
            'type' => CharacterClass::HUNTRESS,
            'level' => $huntressLevel,
        ]);

        $save->characters()->create([
            'type' => CharacterClass::MAGE,
            'level' => $mageLevel,
        ]);

        return $save;
    }
}