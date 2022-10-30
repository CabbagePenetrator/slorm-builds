<?php

namespace App\Http\Controllers;

use App\Models\Build;
use Illuminate\Http\Request;

class BuildController extends Controller
{
    public function index()
    {
        return inertia('Builds/Index', [
            'builds' => Build::all(),
        ]);
    }

    public function create()
    {
        return inertia('Builds/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:1024', 'mimetypes:text/plain'],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        $build = Build::create(
            $request->only(
                'title',
                'description'
            )
        );

        return to_route('builds.show', $build);
    }

    public function show(Build $build)
    {
        return inertia('Builds/Show', [
            'build' => $build,
        ]);
    }

    public function edit(Build $build)
    {
        return inertia('Builds/Edit', [
            'build' => $build,
        ]);
    }

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

        return response()->noContent();
    }

    public function destroy(Build $build)
    {
        $build->delete();

        return response()->noContent();
    }
}
