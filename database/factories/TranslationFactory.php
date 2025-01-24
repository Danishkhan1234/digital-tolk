<?php

namespace Database\Factories;

use App\Enum\TagEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lang' => $this->fake()->randomElement(['en', 'es', 'fr']),
            'tags' => json_encode([
                $this->fake()->randomElement(TagEnum::cases())->value,
                $this->fake()->optional()->randomElement(TagEnum::cases())->value,
            ]),
            'key' => $this->faker->unique()->word(),
            'value' => $this->faker->sentence(),
        ];
    }
}
