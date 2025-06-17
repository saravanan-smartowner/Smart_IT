<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'phone',
        'email',
        'products_services_supplied',
        'sla_terms',
        'escalation_matrix',
    ];

    // Relationships
    public function assets()
    {
        // A vendor can be directly linked to assets if an asset has a 'vendor_id' for supplier info
        return $this->hasMany(Asset::class);
    }

    public function purchases()
    {
        // A vendor can have many purchase orders
        return $this->hasMany(Purchase::class);
    }

    public function softwareLicenses()
    {
        // A vendor can supply many software licenses
        return $this->hasMany(SoftwareLicense::class);
    }

    // You might also have a relationship for Warranties if a vendor is an AMC provider
    // public function warranties()
    // {
    //     return $this->hasMany(Warranty::class, 'amc_vendor_id'); // Assuming 'amc_vendor_id' on warranties table
    // }
}
