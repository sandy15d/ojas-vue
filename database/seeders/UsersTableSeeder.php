<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all available roles
        $roles = Role::all();

        // Create 100 users with random module access
        User::factory()
            ->count(100)
            ->withoutTwoFactor()
            ->create()
            ->each(function (User $user) use ($roles) {
                // Randomly assign 0-3 roles to each user
                if ($roles->isNotEmpty() && fake()->boolean(60)) {
                    $randomRoles = $roles->random(fake()->numberBetween(1, min(3, $roles->count())));
                    $user->syncRoles($randomRoles);
                }
            });

        $this->command->info('Created 100 users with random module access and roles.');
    }
}
