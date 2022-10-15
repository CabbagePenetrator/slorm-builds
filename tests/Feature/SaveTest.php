<?php

use App\Actions\ParseSaveFile;
use App\Models\Save;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

it('can be created', function () {
    $this->get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Saves/Create')
        );
});

it('can be uploaded', function () {
    $file = new UploadedFile($this->getSaveFilePath('save_1'), 'save_1');

    $this
        ->post('/save', [
            'file' => $file
        ])
        ->assertRedirect('/save/1');

    $this->assertDatabaseCount(Save::class, 1);
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

it('can parse save', function () {
    $file = new UploadedFile($this->getSaveFilePath('save_1'), 'save_1');

    $data = (new ParseSaveFile)->execute($file);

    expect($data['version'])->toBe('0.4.6a');
});