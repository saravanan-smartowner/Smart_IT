<?php

namespace App\Models;
use App\Models\AuditLog;
use App\Models\AssetAssignment;
use App\Models\Asset;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role; // Ensure Role is imported for the existing relationship

class User extends Authenticatable // Removed implements MustVerifyEmail for simplicity if not used
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Added role_id
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
public function assets()\n    {\n        return $this->hasMany(Asset::class, 'assigned_to');\n    }\n
public function assetAssignments()\n    {\n        return $this->hasMany(AssetAssignment::class);\n    }\n
public function auditLogs()\n    {\n        return $this->hasMany(AuditLog::class);\n    }\n

    /**\n     * Check if the user has a specific role.\n     *\n     * @param  string  $role\n     * @return bool\n     */\n    public function hasRole(string $role): bool\n    {\n        return $this->role->name === $role;\n    }\n
}
