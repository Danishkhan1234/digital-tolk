<?php

namespace Database\Seeders;

use App\Enums\TagEnum;
use App\Models\Translation;
use Faker\Generator as Faker;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(Faker $faker): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('123456'),
        ]);

        $data = [];

        for ($i = 0; $i < 100000; $i++) {
            $data[] = [
                'user_id' => 1,
                'lang' => $faker->randomElement(['en', 'es', 'fr']),
                'tags' => json_encode([
                    $faker->randomElement(TagEnum::cases())->value,
                    optional($faker->randomElement(TagEnum::cases()))->value,
                ]),
                'key' => $faker->word().$i,
                'value' => $faker->sentence(),
            ];
        }

        $chunks = array_chunk($data, 10000);

        foreach ($chunks as $chunk) {
            Translation::insert($chunk);
        }
    }
}
