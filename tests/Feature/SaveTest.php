<?php

use App\Models\Save;
use App\Models\Character;
use Illuminate\Http\File;
use App\Enums\CharacterClass;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can be created', function () {
    $this->get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Saves/Create')
        );
});

it('can be uploaded', function () {
    $file = new UploadedFile(
        path: $this->getSaveFilePath('save_1'), 
        originalName: 'save_1', 
        test: true
    );

    $this
        ->post('/save', [
            'file' => $file
        ])
        ->assertRedirect('/save/1');

    $this->assertDatabaseHas(Save::class, [
        'version' => '0.4.6a',
    ]);

    $this->assertDatabaseHas(Character::class, [
        'save_id' => 1,
        'type' => CharacterClass::WARRIOR,
        'xp' => 0,
    ]);

    $this->assertDatabaseHas(Character::class, [
        'save_id' => 1,
        'type' => CharacterClass::HUNTRESS,
        'xp' => 0,
    ]);

    $this->assertDatabaseHas(Character::class, [
        'save_id' => 1,
        'type' => CharacterClass::MAGE,
        'xp' => 916384431,
    ]);
});

it('can be viewed', function () {
    $save = Save::factory()->create();

    $this->get('/save/' . $save->id)
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Saves/Show')
                ->has('save')
        );
});