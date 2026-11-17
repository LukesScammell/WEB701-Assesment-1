<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $game = fake()->randomElement([
            'Minecraft',
            'Rocket League',
            'Fortnite',
            'Valorant',
        ]);

        return [
            'name' => $game . ' Tournament',
            'description' => fake()->paragraph(3),
            'game' => $game,
            'event_date' => fake()->dateTimeBetween('+1 day', '+3 months')->format('Y-m-d'),
            'event_time' => '13:00:00',
            'location' => fake()->randomElement([
                'Online',
                'Auckland Community Centre',
                'Wellington Esports Arena',
            ]),
            'max_teams' => fake()->numberBetween(8, 24),
            'team_size' => fake()->numberBetween(2, 5),
        ];
    }
}
