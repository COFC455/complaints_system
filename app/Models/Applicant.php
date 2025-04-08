<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'mobile_phone',
        'national_id',
        'address',

    ];


    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function applicantAttachments(): HasMany
    {
        return $this->hasMany(ApplicantAttachment::class);
    }

}
