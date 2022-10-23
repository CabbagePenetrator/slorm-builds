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
        ->post('/characters', [
            'file' => $file,
        ])
        ->assertOk()
        ->assertJson([
            [
                'name' => CharacterClass::WARRIOR->name(),
                'level' => 1,
            ],
            [
                'name' => CharacterClass::HUNTRESS->name(),
                'level' => 1,
            ],
            [
                'name' => CharacterClass::MAGE->name(),
                'level' => 60,
            ]
        ]);
});
