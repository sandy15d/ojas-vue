<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'has_admin_access',
        'has_sales_access',
        'has_hr_access',
        'has_cogs_access',
        'has_budget_access',
        'default_module',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'has_admin_access' => 'boolean',
            'has_sales_access' => 'boolean',
            'has_hr_access' => 'boolean',
            'has_cogs_access' => 'boolean',
            'has_budget_access' => 'boolean',
        ];
    }

    public function hasModuleAccess(string $moduleIdentifier): bool
    {
        return match ($moduleIdentifier) {
            'sales' => $this->has_sales_access,
            'admin' => $this->has_admin_access,
            'hr' => $this->has_hr_access,
            'cogs' => $this->has_cogs_access,
            'budget' => $this->has_budget_access,
            default => false,
        };
    }

    public function getAccessibleModules(): array
    {
        $modules = [];

        if ($this->has_admin_access) {
            $modules[] = 'admin';
        }
        if ($this->has_sales_access) {
            $modules[] = 'sales';
        }

        if ($this->has_hr_access) {
            $modules[] = 'hr';
        }

        if ($this->has_cogs_access) {
            $modules[] = 'cogs';
        }

        if ($this->has_budget_access) {
            $modules[] = 'budget';
        }

        return $modules;
    }

    public function getDefaultModule(): ?string
    {
        if ($this->default_module && $this->hasModuleAccess($this->default_module)) {
            return $this->default_module;
        }

        $accessibleModules = $this->getAccessibleModules();

        return $accessibleModules[0] ?? null;
    }
}
