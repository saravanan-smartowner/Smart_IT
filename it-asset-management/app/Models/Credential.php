<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Credential extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Name for the credential entry itself
        'url',
        'ip_address', // Can store IP or IP:Port
        'username',
        'password', // Will be encrypted via mutator
        'notes_configurations',
        'asset_id', // Foreign key to assets table
        'software_license_id', // Foreign key to software_licenses table
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // Always hide encrypted password from direct array/JSON output
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // No specific casts needed here unless you have date fields or specific types
    // protected $casts = [];

    // Mutator to encrypt the password when setting it
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) { // Only encrypt if a value is provided
            $this->attributes['password'] = Crypt::encryptString($value);
        }
    }

    // Accessor to decrypt the password when getting it
    // IMPORTANT: Use this accessor sparingly and never display decrypted passwords directly in views.
    // It's primarily for cases where you might need to pass the decrypted password to another system (rarely needed).
    public function getDecryptedPasswordAttribute()
    {
        if (empty($this->attributes['password'])) {
            return null;
        }
        try {
            return Crypt::decryptString($this->attributes['password']);
        } catch (DecryptException $e) {
            // Log the error or handle it appropriately
            // report($e);
            return null; // Or throw an exception, or return a specific error indicator
        }
    }

    // Relationships
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function softwareLicense()
    {
        return $this->belongsTo(SoftwareLicense::class);
    }
}
