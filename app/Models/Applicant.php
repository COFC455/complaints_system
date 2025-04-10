<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function attachments()
    {
        return $this->hasManyThrough(
            ApplicantAttachment::class,
            Request::class,
            'applicant_id', // Foreign key on requests table
            'request_id',   // Foreign key on applicant_attachments table
            'id',           // Local key on applicants table
            'id'            // Local key on requests table
        );
    }

}
