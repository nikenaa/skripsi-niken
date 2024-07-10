<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{

    protected $model = \App\Models\Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker = \Faker\Factory::create('id_ID');

        return [
            'nama'       => $this->faker->randomElement([
                "AWINET GLOBAL MANDIRI", "SISTELINDO MITRALINTAS", "BANDA TELEKOMUNIKASI PERKASA", "NEXA MEDIA PRATAMA",
                "UWAIS BORNEO GROUP", "FAJAR INFORMASI GLOBALNET JAYA", "INTEGRASI TUNAS MUDA", "CI GRAFIKA PROMOSINDO", "MAMURA INTER MEDIA",
                "ANDALAN PRATAMA INDONUSA", "TOP CLASS UNIVERSAL",
            ]) . " - " . $this->faker->city(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => $this->faker->randomElement([now(), null]),
        ];
    }
}
