<?php

namespace App\Models;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\SoftwareLicense;
use App\Models\Asset;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
    protected $fillable = ['asset_id', 'software_license_id', 'credential_type', 'username', 'password', 'notes'];
{
    //
public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function softwareLicense()
    {
        return $this->belongsTo(SoftwareLicense::class);
    }

    public function setPasswordAttribute($value)\n    {\n        $this->attributes['password'] = Crypt::encryptString($value);\n    }\n\n    public function getPasswordAttribute($value)\n    {\n        try {\n            return Crypt::decryptString($value);\n        } catch (DecryptException $e) {\n            // Log the error or handle it appropriately\n            // Returning null or an empty string might be suitable alternatives\n            report($e);\n            return null; \n        }\n    }\n
}
