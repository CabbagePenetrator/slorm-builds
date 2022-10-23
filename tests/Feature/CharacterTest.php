<?php

use App\Enums\CharacterClass;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can get characters', function () {
    $file = new UploadedFile(
        path: $this->getSaveFilePath('save_1'),
        originalName: 'save_1',
        test: true
    );

    $this
        ->post('/save/characters', [
            'file' => $file,
        ])
        ->assertOk()
        ->assertJson([
            [
                'type' => CharacterClass::WARRIOR->value,
                'level' => 1,
            ],
            [
                'type' => CharacterClass::HUNTRESS->value,
                'level' => 1,
            ],
            [
                'type' => CharacterClass::MAGE->value,
                'level' => 60,
            ]
        ]);
});
