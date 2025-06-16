<?php

namespace App\Models;
use App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    //
public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
