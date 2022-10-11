<?php

namespace App\Http\Controllers;

use App\Models\Save;
use Illuminate\Http\Request;

class SavesController extends Controller
{
    public function create()
    {
        return inertia('Saves/Create');
    }

    public function store(Request $request)
    {
        $save = Save::query()->create();
        
        return to_route('saves.show', $save);
    }

    public function show(Save $save)
    {
        return inertia('Saves/Show', [
            'save' => $save,
        ]);
    }
}
