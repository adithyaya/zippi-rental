<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'document_file',
        'verification_status',
        'remarks',
        'verified_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}