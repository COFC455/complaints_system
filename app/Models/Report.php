<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'generated_by',
        'report_type',
        'data',
    ];


    public function generatedUser()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

}
