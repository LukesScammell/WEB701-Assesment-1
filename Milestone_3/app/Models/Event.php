<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'event_date',
        'event_time',
        'location',
        'game',
        'max_teams',
        'team_size',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'max_teams' => 'integer',
            'team_size' => 'integer',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
