<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Traits\Auditable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    use Auditable;

    public function index()
    {
        return Profile::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'sections' => 'required|array',
        ]);

        $profile = Profile::create([
            'code'     => 'PRF-' . strtoupper(Str::random(6)),
            'name'     => $request->name,
            'sections' => $request->sections,
        ]);

        $this->logAudit('profile', 'created', null, $profile->toArray());

        return response()->json($profile, 201);
    }

    public function show($id)
    {
        return Profile::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $oldData = $profile->toArray();

        $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'sections' => 'sometimes|required|array',
        ]);

        $profile->update($request->only(['name', 'sections']));

        $this->logAudit('profile', 'updated', $oldData, $profile->toArray());

        return response()->json($profile);
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $oldData = $profile->toArray();

        $profile->delete();

        $this->logAudit('profile', 'deleted', $oldData, null);

        return response()->json(['message' => 'Perfil eliminado']);
    }
}