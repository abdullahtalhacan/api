<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('tr_TR');
        return [
            "uuid" => Str::uuid(),
            "score" => $faker->numberBetween(1, 10),
            "comment" => $faker->paragraph(),
            "is_anonymous" => $faker->randomElement([true, false])
        ];
    }
}
