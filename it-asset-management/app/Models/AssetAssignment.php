<?php

namespace App\Models;
use App\Models\User;
use App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{
    //
public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
