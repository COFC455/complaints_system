<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class request_types extends Model
{
    protected $fillable = [
        'type_name',
        'description',
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
}
