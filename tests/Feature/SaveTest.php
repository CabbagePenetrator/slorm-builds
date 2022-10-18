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

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::HELMET,
        'level' => 56,
        'reinforcement' => 6,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::BODY,
        'level' => 60,
        'reinforcement' => 8,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::SHOULDER,
        'level' => 55,
        'reinforcement' => 6,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::BRACERS,
        'level' => 60,
        'reinforcement' => 7,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::GLOVE,
        'level' => 60,
        'reinforcement' => 7,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::BOOT,
        'level' => 60,
        'reinforcement' => 8,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::RING,
        'level' => 55,
        'reinforcement' => 8,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::RING,
        'level' => 47,
        'reinforcement' => 9,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::AMULET,
        'level' => 60,
        'reinforcement' => 8,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::BELT,
        'level' => 59,
        'reinforcement' => 8,
    ]);

    $this->assertDatabaseHas(Item::class, [
        'character_id' => 3,
        'type' => ItemType::CAPE,
        'level' => 58,
        'reinforcement' => 9,
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