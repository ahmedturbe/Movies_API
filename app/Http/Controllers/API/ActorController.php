<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActorRequest;
use App\Models\Actor;
use App\Models\Image;
use App\Services\Slugger;   // Assuming you have a Slugger service for generating slugs
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ActorController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return Actor::all();
    }
    public function store(Request $request)
    {
        $this->authorize('create', Actor::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $slug = Slugger::generate($validated['name']);

        if (Actor::where('slug', $slug)->exists()) {
            return response()->json(['error' => 'Slug already exists.'], 409);
        }

        $validated['slug'] = $slug;

        $actor = Actor::create($validated);

        return response()->json($actor, 201);
    }
    public function show(string $slug)
    {
        $actor = Actor::where('slug', $slug)->firstOrFail();
        return $actor;
    }
    public function update(Request $request, string $slug)
    {
        $actor = Actor::where('slug', $slug)->firstOrFail();
        $this->authorize('update', $actor);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $newSlug = Slugger::generate($validated['name']);

        if (Actor::where('slug', $newSlug)->where('id', '!=', $actor->id)->exists()) {
            return response()->json(['error' => 'Slug already exists.'], 409);
        }

        $validated['slug'] = $newSlug;

        $actor->update($validated);

        return response()->json($actor);
    }
    public function destroy(string $slug)
    {
        $actor = Actor::where('slug', $slug)->firstOrFail();
        $this->authorize('delete', $actor);

        $actor->delete();

        return response()->noContent();
    }
}
