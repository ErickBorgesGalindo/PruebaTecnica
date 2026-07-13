<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $token = auth('api')->tokenById($user->id);

        $profiles = $this->getUserProfiles($user->id);

        return response()->json([
            'token'    => $token,
            'user'     => $user,
            'profiles' => $profiles['profiles'],
            'sections' => $profiles['sections'],
        ]);
    }

    public function logout()
    {
        auth('api')->invalidate(true);

        return response()->json(['message' => 'Sesión cerrada']);
    }

    public function me()
    {
        $user = auth('api')->user();
        $profiles = $this->getUserProfiles($user->id);

        return response()->json([
            'user'     => $user,
            'profiles' => $profiles['profiles'],
            'sections' => $profiles['sections'],
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe'], 404);
        }

        $tempPassword = 'temp' . rand(10000, 99999);
        $user->password = Hash::make($tempPassword);
        $user->save();

        return response()->json([
            'message' => 'Se ha generado una nueva contraseña temporal',
            'temp_password' => $tempPassword,
        ]);
    }

    private function getUserProfiles($userId)
    {
        $relations = UserProfile::where('user_id', $userId)->get();
        $profiles = [];
        $allSections = [];

        foreach ($relations as $rel) {
            $profile = Profile::find($rel->profile_id);
            if ($profile) {
                $profiles[] = [
                    'id'       => $profile->id,
                    'code'     => $profile->code,
                    'name'     => $profile->name,
                    'sections' => $profile->sections,
                ];
                $allSections = array_merge($allSections, $profile->sections);
            }
        }

        return [
            'profiles' => $profiles,
            'sections' => array_unique($allSections),
        ];
    }
}