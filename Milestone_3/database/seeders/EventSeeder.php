<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'name' => 'Pixel Pals Minecraft Tournament',
            'description' => 'A friendly Minecraft competition where teams compete in challenges and activities.',
            'event_date' => '2026-11-20',
            'event_time' => '10:00:00',
            'location' => 'Auckland Community Centre',
            'game' => 'Minecraft',
            'max_teams' => 12,
        ]);

        Event::create([
            'name' => 'Pixel Pals Rocket League Championship',
            'description' => 'Teams compete in a Rocket League tournament to support the Pixel Pals community.',
            'event_date' => '2026-11-28',
            'event_time' => '13:00:00',
            'location' => 'Online',
            'game' => 'Rocket League',
            'max_teams' => 16,
        ]);

        Event::create([
            'name' => 'Pixel Pals Fortnite Competition',
            'description' => 'A community Fortnite competition bringing young gamers together.',
            'event_date' => '2026-12-05',
            'event_time' => '11:00:00',
            'location' => 'Online',
            'game' => 'Fortnite',
            'max_teams' => 20,
        ]);
    }
}
