<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Auditable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Auditable;

    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'photo_url' => 'required|string',
            'phone'     => 'nullable|string',
        ]);

        $user = User::create([
            'code'      => 'USR-' . strtoupper(Str::random(6)),
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'photo_url' => $request->photo_url,
            'password'  => Hash::make('temporal123'),
        ]);

        $this->logAudit('user', 'created', null, $user->toArray());

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldData = $user->toArray();

        $request->validate([
            'name'      => 'sometimes|required|string|max:255',
            'email'     => 'sometimes|required|email',
            'phone'     => 'nullable|string',
            'photo_url' => 'nullable|string',
        ]);

        if ($request->has('email') && $request->email !== $user->email) {
            $existing = User::where('email', $request->email)->first();
            if ($existing) {
                return response()->json(['message' => 'El email ya está en uso'], 422);
            }
        }

        $data = $request->only(['name', 'email', 'phone', 'photo_url']);

        $user->update($data);

        $this->logAudit('user', 'updated', $oldData, $user->toArray());

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $oldData = $user->toArray();

        $user->delete();

        $this->logAudit('user', 'deleted', $oldData, null);

        return response()->json(['message' => 'Usuario eliminado']);
    }
}