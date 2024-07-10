<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama'      => 'Niken Ayunda Lestari',
            'username'  => 'niken',
            'password'  => 'niken',
            'role'      => 1,
            'is_active' => 1,
            'foto'      => 'default.jpg',
        ];
    }
}
