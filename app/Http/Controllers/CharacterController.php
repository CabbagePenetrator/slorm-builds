<?php

namespace App\Http\Controllers;

use App\Actions\ParseSaveFile;
use App\Enums\CharacterClass;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Actions\ParseSaveFile $parseSaveFileAction
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, ParseSaveFile $parseSaveFileAction)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimetypes:text/plain', 'max:1024'],
        ]);

        $data = $parseSaveFileAction->execute(
            $request->file('file')
        );

        [
            $warriorLevel,
            $huntressLevel,
            $mageLevel
        ] = $data['levels'];

        return response()->json([
            [
                'name' => CharacterClass::WARRIOR->name(),
                'level' => $warriorLevel,
                'value' => CharacterClass::WARRIOR->value,
            ],
            [
                'name' => CharacterClass::HUNTRESS->name(),
                'level' => $huntressLevel,
                'value' => CharacterClass::HUNTRESS->value,
            ],
            [
                'name' => CharacterClass::MAGE->name(),
                'level' => $mageLevel,
                'value' => CharacterClass::MAGE->value,
            ],
        ]);
    }
}
