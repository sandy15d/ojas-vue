<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modules = ['admin', 'sales', 'hr', 'cogs', 'budget'];
        $hasModuleAccess = fake()->boolean(70); // 70% chance of having at least one module

        if ($hasModuleAccess) {
            $randomModules = fake()->randomElements($modules, fake()->numberBetween(1, count($modules)));
            $defaultModule = fake()->randomElement($randomModules);
        } else {
            $randomModules = [];
            $defaultModule = null;
        }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= 'password',
            'remember_token' => Str::random(10),
            'two_factor_secret' => Str::random(10),
            'two_factor_recovery_codes' => Str::random(10),
            'two_factor_confirmed_at' => now(),
            'has_admin_access' => in_array('admin', $randomModules),
            'has_sales_access' => in_array('sales', $randomModules),
            'has_hr_access' => in_array('hr', $randomModules),
            'has_cogs_access' => in_array('cogs', $randomModules),
            'has_budget_access' => in_array('budget', $randomModules),
            'default_module' => $defaultModule,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model does not have two-factor authentication configured.
     */
    public function withoutTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }
}
