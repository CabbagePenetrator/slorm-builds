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
                'type' => CharacterClass::WARRIOR,
                'level' => $warriorLevel,
            ],
            [
                'type' => CharacterClass::HUNTRESS,
                'level' => $huntressLevel,
            ],
            [
                'type' => CharacterClass::MAGE,
                'level' => $mageLevel,
            ],
        ]);
    }
}
