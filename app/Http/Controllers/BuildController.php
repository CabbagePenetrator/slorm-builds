<?php

namespace App\Http\Controllers;

use App\Models\Build;
use Illuminate\Http\Request;
use App\Enums\CharacterClass;
use Illuminate\Validation\Rules\Enum;

class BuildController extends Controller
{
    /**
     * Display all builds.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return inertia('Builds/Index', [
            'builds' => Build::filter($request->only('character'))->get(),
        ]);
    }

    /**
     * Show the form for creating a new build.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return inertia('Builds/Create');
    }

    /**
     * Store the newly created build in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:1024', 'mimetypes:text/plain'],
            'character' => ['required', new Enum(CharacterClass::class)],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        $build = $request->user()->builds()->create(
            $request->only(
                'character',
                'title',
                'description'
            )
        );

        return to_route('builds.show', $build);
    }

    /**
     * Show the build.
     *
     * @param  \App\Models\Build $build
     * @return \Inertia\Response
     */
    public function show(Build $build)
    {
        return inertia('Builds/Show', [
            'build' => $build,
        ]);
    }

    /**
     * Show the form for editing the build.
     *
     * @param  \App\Models\Build $build
     * @return \Inertia\Response
     */
    public function edit(Build $build)
    {
        return inertia('Builds/Edit', [
            'build' => $build,
        ]);
    }

    /**
     * Update the build in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Build $build
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Build $build)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        $build->update(
            $request->only(
                'title',
                'description'
            )
        );

        return to_route('builds.edit', $build);
    }

    /**
     * Remove the build from storage.
     *
     * @param  \App\Models\Build $build
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Build $build)
    {
        $build->delete();

        return to_route('builds');
    }
}
