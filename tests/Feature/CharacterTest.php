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
                'value' => CharacterClass::WARRIOR->value,
            ],
            [
                'name' => CharacterClass::HUNTRESS->name(),
                'level' => 1,
                'value' => CharacterClass::HUNTRESS->value,
            ],
            [
                'name' => CharacterClass::MAGE->name(),
                'level' => 60,
                'value' => CharacterClass::MAGE->value,
            ]
        ]);
});
