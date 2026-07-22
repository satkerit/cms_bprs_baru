<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Auditable;

    protected static function getAuditModelName(): string
    {
        return 'User';
    }

    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the role model relationship
     */
    public function roleModel(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get password history
     */
    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    /**
     * Check if password was recently used
     */
    public function hasUsedPassword(string $password, int $historyCount = 5): bool
    {
        return PasswordHistory::isPasswordReused($this->id, $password, $historyCount);
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Check if user has a specific permission (Spatie compatible)
     */
    public function hasPermissionTo(string $permission): bool
    {
        return $this->hasPermission($permission);
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        // Super admin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Admin has many permissions but restricted on user/role/system settings
        if ($this->isAdmin()) {
            $superAdminOnlyPermissions = [
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
                'roles.view',
                'roles.create',
                'roles.edit',
                'roles.delete',
                'settings.menu',
                'settings.security'
            ];

            if (in_array($permission, $superAdminOnlyPermissions)) {
                return false;
            }
        }

        // Check from Role model relationship
        if ($this->role_id && $this->roleModel) {
            return $this->roleModel->hasPermission($permission);
        }

        return false;
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        // Super admin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Admin has most permissions
        if ($this->isAdmin()) {
            $superAdminOnlyPermissions = ['users.view', 'roles.view', 'settings.menu'];
            foreach ($permissions as $permission) {
                if (!in_array($permission, $superAdminOnlyPermissions)) {
                    return true;
                }
            }
        }

        // Check from Role model relationship
        if ($this->role_id && $this->roleModel) {
            return $this->roleModel->hasAnyPermission($permissions);
        }

        return false;
    }

    // RBAC Methods

    /**
     * Get role data from session cache (set by SecureSessionMiddleware).
     * Falls back to database relationship when session cache is unavailable.
     *
     * @return array{name: string|null, permissions: array}|null
     */
    private function getSessionRoleData(): ?array
    {
        return Session::get('cached_role');
    }

    /**
     * Get cached permission names for this user.
     * Uses session cache if available, otherwise queries the database.
     *
     * @return array<int, string>
     */
    private function getUserPermissionNames(): array
    {
        $cached = $this->getSessionRoleData();
        if ($cached && isset($cached['permissions'])) {
            return $cached['permissions'];
        }

        // Fallback: query database
        if ($this->role_id && $this->roleModel?->relationLoaded('permissions')) {
            return $this->roleModel->permissions->pluck('name')->toArray();
        }

        return [];
    }

    public function isSuperAdmin(): bool
    {
        $cached = $this->getSessionRoleData();
        if ($cached) {
            return $cached['name'] === self::ROLE_SUPER_ADMIN;
        }
        return $this->roleModel?->name === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        $cached = $this->getSessionRoleData();
        if ($cached) {
            return in_array($cached['name'], [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN]);
        }
        return in_array($this->roleModel?->name, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN]);
    }

    public function isEditor(): bool
    {
        $cached = $this->getSessionRoleData();
        if ($cached) {
            return $cached['name'] === self::ROLE_EDITOR;
        }
        return $this->roleModel?->name === self::ROLE_EDITOR;
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $cached = $this->getSessionRoleData();
        if ($cached) {
            return in_array($cached['name'], $roles);
        }
        return in_array($this->roleModel?->name, $roles);
    }

    public function canManageContent(): bool
    {
        if ($this->hasAnyPermission(['news.view', 'products.view', 'auctions.view'])) {
            return true;
        }
        return $this->isAdmin() || $this->isEditor();
    }

    public function canManageUsers(): bool
    {
        $cached = $this->getSessionRoleData();
        if ($cached) {
            return $cached['name'] === self::ROLE_SUPER_ADMIN;
        }
        return $this->roleModel?->name === self::ROLE_SUPER_ADMIN;
    }

    public function canManageSettings(): bool
    {
        $cached = $this->getSessionRoleData();
        if ($cached) {
            return in_array($cached['name'], [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN]);
        }
        return in_array($this->roleModel?->name, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN]);
    }

    /**
     * Get role name
     */
    public function getRoleName(): string
    {
        return $this->roleModel?->name ?? 'editor';
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayName(): string
    {
        return $this->roleModel?->display_name ?? 'Editor';
    }

    /**
     * Get available roles (for backward compatibility)
     * @deprecated Use Role model directly
     */
    public static function getRoles(): array
    {
        return Role::orderBy('name')->pluck('display_name', 'name')->toArray();
    }
}
