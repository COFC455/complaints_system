<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    protected $fillable = [
        'status_name',
        'description',
    ];

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }


    public function trackings(): HasMany
    {
        return $this->hasMany(Tracking::class);
    }
}
