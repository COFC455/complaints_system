<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantAttachment extends Model
{
    protected $fillable = [
        'applicant_id',
        'request_id',
        'file_path',
        'uploaded_at'
    ];

    //request
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

    //applicant
        public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

}