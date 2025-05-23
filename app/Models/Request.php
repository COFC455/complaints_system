<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    protected $fillable = [
        'applicant_id',
        'category_id',
        'branch_id',
        'user_id',
        'request_type_id',
        'request_status_id',
        'city_id',
        'status',
        'description',
        'concerned_entities',
        'reference_code',
        'is_received'
    ];


//applicant
public function applicant(): BelongsTo
{
    return $this->belongsTo(Applicant::class);
}

//category
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}

//branch
public function branch(): BelongsTo
{
    return $this->belongsTo(Branche::class);
}

//city
public function city(): BelongsTo
{
    return $this->belongsTo(City::class);
}

//request_type
public function request_type(): BelongsTo
{
    return $this->belongsTo(request_types::class);
}
//request_status
public function request_status(): BelongsTo
{
    return $this->belongsTo(RequestStatus::class);
}

//trackings

public function trackings(): HasMany
{
    return $this->hasMany(Tracking::class, 'request_id', 'id');
}

//ApplicantAttachment

public function applicant_attachments(): HasMany
{
    return $this->hasMany(ApplicantAttachment::class);
}

    //SysyemFiles
    public function systemFiles(): HasMany
    {
        return $this->hasMany(SystemAttachment::class);
    }


    //users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
