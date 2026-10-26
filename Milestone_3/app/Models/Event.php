<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'event_date',
        'event_time',
        'location',
        'game',
        'max_teams',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'max_teams' => 'integer',
        ];
    }
}
