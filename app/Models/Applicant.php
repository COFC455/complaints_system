<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'national_id'
    ];


    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

}
