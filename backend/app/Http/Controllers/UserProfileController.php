<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\Profile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        return UserProfile::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|string',
            'profile_id' => 'required|string',
        ]);

        $exists = UserProfile::where('user_id', $request->user_id)
            ->where('profile_id', $request->profile_id)
            ->first();

        if ($exists) {
            return response()->json(['message' => 'Este perfil ya está asignado al usuario'], 422);
        }

        $relation = UserProfile::create([
            'user_id'    => $request->user_id,
            'profile_id' => $request->profile_id,
        ]);

        return response()->json($relation, 201);
    }

    public function destroy($id)
    {
        UserProfile::findOrFail($id)->delete();

        return response()->json(['message' => 'Relación eliminada']);
    }

    public function userProfiles($userId)
    {
        $relations = UserProfile::where('user_id', $userId)->get();

        $profiles = [];
        foreach ($relations as $rel) {
            $profile = Profile::find($rel->profile_id);
            if ($profile) {
                $profiles[] = [
                    'relation_id' => $rel->id,
                    'id'          => $profile->id,
                    'code'        => $profile->code,
                    'name'        => $profile->name,
                    'sections'    => $profile->sections,
                ];
            }
        }

        return response()->json($profiles);
    }
}