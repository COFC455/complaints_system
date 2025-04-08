<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tracking extends Model
{
    //
    protected $fillable = [
        'request_id',
        'updated_by',
        'request_status_id',
        'comment'
    ];

    //request
    public function requests(): BelongsTo
    {
        return $this->belongsTo(Request::class,'request_id','id' );
    }


    //updated by
    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    //request_status
    public function request_status(): BelongsTo
    {
        return $this->belongsTo(RequestStatus::class);
    }
}
