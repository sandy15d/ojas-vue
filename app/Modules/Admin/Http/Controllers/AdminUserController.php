<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::query()->with(['permissions', 'roles']);

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->input('role'));
            });
        }

        // Filter by module access
        if ($request->filled('module')) {
            $module = $request->input('module');
            $query->where("has_{$module}_access", true);
        }

        // Sort
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Paginate
        $perPage = $request->input('per_page', 15);
        $users = $query->paginate($perPage)->through(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'has_admin_access' => $user->has_admin_access,
                'has_sales_access' => $user->has_sales_access,
                'has_hr_access' => $user->has_hr_access,
                'has_cogs_access' => $user->has_cogs_access,
                'has_budget_access' => $user->has_budget_access,
                'default_module' => $user->default_module,
                'permissions_count' => $user->permissions->count(),
                'roles' => $user->roles->pluck('name')->toArray(),
                'created_at' => $user->created_at->diffForHumans(),
            ];
        });

        $roles = Role::query()
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            });

        return Inertia::render('modules/Admin/Users/Index', [
            'users' => $users,
            'roles' => $roles,
            'filters' => $request->only(['search', 'role', 'module', 'per_page']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'has_admin_access' => ['boolean'],
            'has_sales_access' => ['boolean'],
            'has_hr_access' => ['boolean'],
            'has_cogs_access' => ['boolean'],
            'has_budget_access' => ['boolean'],
            'default_module' => ['nullable', 'string', 'in:admin,sales,hr,cogs,budget'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'has_admin_access' => $validated['has_admin_access'] ?? false,
            'has_sales_access' => $validated['has_sales_access'] ?? false,
            'has_hr_access' => $validated['has_hr_access'] ?? false,
            'has_cogs_access' => $validated['has_cogs_access'] ?? false,
            'has_budget_access' => $validated['has_budget_access'] ?? false,
            'default_module' => $validated['default_module'] ?? null,
        ]);

        if (isset($validated['roles']) && is_array($validated['roles'])) {
            $roleIds = array_filter($validated['roles']);
            if (! empty($roleIds)) {
                $roles = Role::whereIn('id', $roleIds)->get();
                $user->syncRoles($roles);
            }
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): Response
    {
        // Load roles relationship
        $user->load('roles');

        $roles = Role::query()
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            });

        return Inertia::render('modules/Admin/Users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'has_admin_access' => $user->has_admin_access,
                'has_sales_access' => $user->has_sales_access,
                'has_hr_access' => $user->has_hr_access,
                'has_cogs_access' => $user->has_cogs_access,
                'has_budget_access' => $user->has_budget_access,
                'default_module' => $user->default_module,
                'role_ids' => $user->roles->pluck('id')->toArray(),
            ],
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'has_admin_access' => ['boolean'],
            'has_sales_access' => ['boolean'],
            'has_hr_access' => ['boolean'],
            'has_cogs_access' => ['boolean'],
            'has_budget_access' => ['boolean'],
            'default_module' => ['nullable', 'string', 'in:admin,sales,hr,cogs,budget'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'has_admin_access' => $validated['has_admin_access'] ?? false,
            'has_sales_access' => $validated['has_sales_access'] ?? false,
            'has_hr_access' => $validated['has_hr_access'] ?? false,
            'has_cogs_access' => $validated['has_cogs_access'] ?? false,
            'has_budget_access' => $validated['has_budget_access'] ?? false,
            'default_module' => $validated['default_module'] ?? null,
        ]);

        if (isset($validated['roles'])) {
            $roleIds = array_filter($validated['roles']);
            $roles = Role::whereIn('id', $roleIds)->get();
            $user->syncRoles($roles);
        } else {
            $user->syncRoles([]);
        }

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function editPassword(User $user): Response
    {
        return Inertia::render('modules/Admin/Users/Password', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
        ]);
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.users.password.edit', $user)
            ->with('success', 'Password updated successfully.');
    }

    public function editPermissions(User $user): Response
    {
        $permissions = Permission::query()
            ->orderBy('name')
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                ];
            });

        return Inertia::render('modules/Admin/Users/Permissions', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'permission_ids' => $user->permissions->pluck('id')->toArray(),
            ],
            'permissions' => $permissions,
        ]);
    }

    public function updatePermissions(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);

        if (isset($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        } else {
            $user->syncPermissions([]);
        }

        return redirect()
            ->route('admin.users.permissions.edit', $user)
            ->with('success', 'Permissions updated successfully.');
    }

    public function export(Request $request)
    {
        $query = User::query()->with(['permissions', 'roles']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->input('role'));
            });
        }

        if ($request->filled('module')) {
            $module = $request->input('module');
            $query->where("has_{$module}_access", true);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users-'.date('Y-m-d').'.csv"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Roles', 'Module Access', 'Permissions', 'Created At']);

            foreach ($users as $user) {
                $modules = [];
                if ($user->has_admin_access) {
                    $modules[] = 'Admin';
                }
                if ($user->has_sales_access) {
                    $modules[] = 'Sales';
                }
                if ($user->has_hr_access) {
                    $modules[] = 'HR';
                }
                if ($user->has_cogs_access) {
                    $modules[] = 'COGS';
                }
                if ($user->has_budget_access) {
                    $modules[] = 'Budget';
                }

                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->roles->pluck('name')->join(', '),
                    implode(', ', $modules),
                    $user->permissions->count(),
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
