<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'software_name',
        'version',
        'license_key', // or subscription_id from your spec
        'number_of_licenses', // or users from your spec
        'activation_date',
        'expiry_date',
        'linked_office_location',
        'vendor_id',
        'support_contact_info',
        // 'renewal_alerts' was in the original spec, but not directly handled by simple CRUD.
        // This would typically be a calculated field or handled by a scheduled task.
        // If you have a specific column for it that's directly set, add it here.
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'activation_date' => 'date:Y-m-d', // Casting to Y-m-d format
        'expiry_date' => 'date:Y-m-d',     // Casting to Y-m-d format
        'number_of_licenses' => 'integer',
    ];

    // Relationships
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // If a software license can be directly associated with credentials
    public function credentials()
    {
        return $this->hasMany(Credential::class);
    }

    // If a software license can be assigned to many assets (devices/users)
    // This would typically be a many-to-many relationship if one license (e.g. a volume license key)
    // can be used for multiple assets, or one-to-many from Asset if an asset has one license key.
    // Example for many-to-many:
    // public function assets()
    // {
    //     return $this->belongsToMany(Asset::class, 'asset_software_license');
    // }
}
