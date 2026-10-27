<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'team_name',
        'contact_name',
        'contact_email',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
