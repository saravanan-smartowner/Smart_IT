<?php

namespace App\Models;
use App\Models\PurchaseItem;
use App\Models\Credential;
use App\Models\Warranty;
use App\Models\AssetAssignment;
use App\Models\Vendor;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //
public function assignedToUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function assetAssignments()
    {
        return $this->hasMany(AssetAssignment::class);
    }

    public function warranties()
    {
        return $this->hasMany(Warranty::class);
    }

    public function credentials()
    {
        return $this->hasMany(Credential::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
