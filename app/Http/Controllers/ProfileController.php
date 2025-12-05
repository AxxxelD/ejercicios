<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with('user')->get();
        return response()->json($profiles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:profiles,user_id',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);

        $profile = Profile::create($request->all());
        return response()->json($profile, 201);
    }

    public function show(Profile $profile)
    {
        return response()->json($profile->load('user'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);

        $profile->update($request->except('user_id'));
        return response()->json($profile);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->json(null, 204);
    }
}
