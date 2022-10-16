<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;
use App\Actions\StoreSave;

class SavesController extends Controller
{
    public function create()
    {
        return inertia('Saves/Create');
    }

    public function store(Request $request, StoreSave $storeSaveAction)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimetypes:text/plain', 'max:1024'],
        ]);

        $save = $storeSaveAction->execute(
            $request->file('file')
        );
        
        return to_route('saves.show', $save);
    }

    public function show(Save $save)
    {
        return inertia('Saves/Show', [
            'save' => $save,
        ]);
    }
}
