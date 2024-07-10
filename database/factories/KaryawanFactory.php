<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $no_induk = $this->faker->unique()->randomNumber(5);

        return [
            'no_induk'     => $no_induk,
            'nama'         => $this->faker->name(),
            'project_id'   => $this->getProjectId(),
            'jenis_kelamin'=> $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'username'     => $this->faker->userName(),
            // 'password'     => bcrypt($no_induk),
            'password'     => $no_induk,
            'role'         => $this->faker->randomElement([1, 2, 3]),
            'is_active'    => $this->faker->randomElement([1, 0]),
            'foto'         => 'default.jpg',
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }

    // function to get randomly id from project table
    public function getProjectId()
    {
        return \App\Models\Project::inRandomOrder()->first()->id;
    }
}
