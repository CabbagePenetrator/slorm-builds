<?php

use App\Models\Item;
use App\Models\Save;
use App\Enums\ItemType;
use App\Models\Character;
use App\Models\Inventory;
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
        'version' => '0.4.6fa',
    ]);

    // Characters
    $this->assertDatabaseHas(Character::class, [
        'save_id' => 1,
        'type' => CharacterClass::WARRIOR,
        'level' => 1,
    ]);

    $this->assertDatabaseHas(Character::class, [
        'save_id' => 1,
        'type' => CharacterClass::HUNTRESS,
        'level' => 1,
    ]);

    $this->assertDatabaseHas(Character::class, [
        'save_id' => 1,
        'type' => CharacterClass::MAGE,
        'level' => 60,
    ]);

    // Inventories
    $this->assertDatabaseHas(Inventory::class, [
        'character_id' => 1,
        'is_stash' => false,
    ]);

    $this->assertDatabaseHas(Inventory::class, [
        'character_id' => 2,
        'is_stash' => false,
    ]);

    $this->assertDatabaseHas(Inventory::class, [
        'save_id' => 1,
        'character_id' => 3,
        'is_stash' => false,
    ]);

    $this->assertDatabaseHas(Inventory::class, [
        'id' => 4,
        'save_id' => 1,
        'is_stash' => true,
    ]);

    $this->assertDatabaseHas(Inventory::class, [
        'id' => 5,
        'save_id' => 1,
        'is_stash' => true,
    ]);

    $this->assertDatabaseHas(Inventory::class, [
        'id' => 6,
        'save_id' => 1,
        'is_stash' => true,
    ]);

    $this->assertDatabaseHas(Inventory::class, [
        'id' => 7,
        'save_id' => 1,
        'is_stash' => true,
    ]);

    foreach (ItemType::cases() as $type) {
        $this->assertDatabaseHas(Item::class, [
            'character_id' => 3,
            'inventory_id' => null,
            'inventory_position' => null,
            'type' => $type,
        ]);
    }
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