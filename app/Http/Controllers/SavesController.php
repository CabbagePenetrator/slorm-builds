<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;
use App\Actions\ParseSaveFile;
use App\Enums\CharacterClass;

class SavesController extends Controller
{
    public function create()
    {
        return inertia('Saves/Create');
    }

    public function store(Request $request, ParseSaveFile $parseSaveFileAction)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimetypes:text/plain', 'max:1024'],
        ]);

        $data = $parseSaveFileAction->execute(
            $request->file('file')
        );

        $save = Save::query()->create([
            'version' => $data['version'],
        ]);

        $xp = str($data['xp'])->explode('|');

        $save->characters()->create([
            'type' => CharacterClass::WARRIOR,
            'xp' => $xp[0],
        ]);

        $save->characters()->create([
            'type' => CharacterClass::HUNTRESS,
            'xp' => $xp[1],
        ]);

        $save->characters()->create([
            'type' => CharacterClass::MAGE,
            'xp' => $xp[2],
        ]);
        
        return to_route('saves.show', $save);
    }

    public function show(Save $save)
    {
        return inertia('Saves/Show', [
            'save' => $save,
        ]);
    }
}
