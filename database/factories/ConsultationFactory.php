<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultant>
 */
class ConsultationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'region_id' => rand(1, 5),
            'organization_id' => rand(1, 5),
            'consultant_id' => rand(1, 5),
            'categori_id' => rand(1, 5),
            'question_id' => rand(1, 5),
            'dateFrom' => $this->faker->dateTimeBetween('-7 day', 'now'),
            'dateTo' => function (array $consultation) {
                return Carbon::parse($consultation['dateFrom'])->addHours($this->faker->numberBetween(1, 24));
            },
        ];
    }
}
