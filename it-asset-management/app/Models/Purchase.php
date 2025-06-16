<?php

namespace App\Models;
use App\Models\PurchaseItem;
use App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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
}
