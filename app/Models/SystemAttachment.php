<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SystemAttachment extends Model
{
    protected $fillable = [
        'request_id',
        'uploaded_by',
        'file_path',
    ];
    
      //updated by
      public function uploadByUser(): BelongsTo
      {
          return $this->belongsTo(User::class, 'uploaded_by');
      }
      

     //request
     public function request(): BelongsTo
     {
         return $this->belongsTo(Request::class);
     }
}
