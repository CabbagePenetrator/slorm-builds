<?php

namespace App\Http\Controllers;

use App\Actions\ParseSaveFile;
use App\Enums\CharacterClass;
use Illuminate\Http\Request;

class CharactersController extends Controller
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
            ],
            [
                'name' => CharacterClass::HUNTRESS->name(),
                'level' => $huntressLevel,
            ],
            [
                'name' => CharacterClass::MAGE->name(),
                'level' => $mageLevel,
            ],
        ]);
    }
}
