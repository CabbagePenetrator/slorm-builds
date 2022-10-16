<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;
use App\Actions\ParseSaveFile;

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
        
        return to_route('saves.show', $save);
    }

    public function show(Save $save)
    {
        return inertia('Saves/Show', [
            'save' => $save,
        ]);
    }
}
