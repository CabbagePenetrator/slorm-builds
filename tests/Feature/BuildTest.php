<?php

use App\Models\Build;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

it('can view all', function () {
    Build::factory()
        ->count(3)
        ->for($this->user)
        ->create();

    get('/builds')
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Builds/Index')
                ->has('builds', 3)
        );
});

it('can view create form', function () {
    get('/builds/create')
        ->assertInertia(fn (Assert $page) => $page
            ->component('Builds/Create')
        );
});

it('can be created', function () {
    $file = new UploadedFile(
        path: $this->getSaveFilePath('save_1'),
        originalName: 'save_1',
        test: true
    );

    post('/builds', [
        'file' => $file,
        'title' => 'New build',
        'description' => 'Build description',
    ])
    ->assertRedirect('/builds/new-build');

    assertDatabaseHas(Build::class, [
        'title' => 'New build',
        'description' => 'Build description',
    ]);
});

it('can be viewed', function () {
    $build = Build::factory()->create();

    get('/builds/'.$build->slug)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Builds/Show')
            ->has('build')
        );
});

it('can view edit form', function () {
    $build = Build::factory()->create();

    get('/builds/' . $build->slug . '/edit')
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Builds/Edit')
        );
});

it('can be updated', function () {
    $build = Build::factory()->create([
        'title' => 'old title',
        'description' => 'old description',
    ]);

    put('/builds/' . $build->id, [
        'title' => 'new title',
        'description' => 'new description',
    ])
    ->assertNoContent();

    assertDatabaseHas(Build::class, [
        'title' => 'new title',
        'description' => 'new description',
    ]);
});

it('can be deleted', function () {
    $build = Build::factory()->create();

    delete('/builds/'.$build->id)
        ->assertNoContent();

    assertDatabaseMissing(Build::class, $build->toArray());
});
