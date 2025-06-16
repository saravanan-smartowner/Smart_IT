<?php

namespace App\Models;
use App\Models\Credential;
use App\Models\PurchaseItem;
use App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class SoftwareLicense extends Model
{
    //
public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function credentials()
    {
        return $this->hasMany(Credential::class);
    }
}
