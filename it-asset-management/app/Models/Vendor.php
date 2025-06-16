<?php

namespace App\Models;
use App\Models\SoftwareLicense;
use App\Models\Purchase;
use App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function softwareLicenses()
    {
        return $this->hasMany(SoftwareLicense::class);
    }
}
