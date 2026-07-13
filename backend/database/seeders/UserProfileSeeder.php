<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@test.com')->first();
        $adminProfile = Profile::where('code', 'PRF-001')->first();
        $readOnlyProfile = Profile::where('code', 'PRF-002')->first();

        if ($admin && $adminProfile) {
            UserProfile::firstOrCreate([
                'user_id'    => $admin->id,
                'profile_id' => $adminProfile->id,
            ]);
        }

        $maria = User::where('email', 'maria@test.com')->first();
        if ($maria && $readOnlyProfile) {
            UserProfile::firstOrCreate([
                'user_id'    => $maria->id,
                'profile_id' => $readOnlyProfile->id,
            ]);
        }
    }
}