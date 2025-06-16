<?php

namespace App\Models;
use App\Models\SoftwareLicense;
use App\Models\Asset;
use App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    //
public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function softwareLicense()
    {
        return $this->belongsTo(SoftwareLicense::class);
    }
}
