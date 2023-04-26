<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = ["admin", "teacher", "student"];
        $rol = collect($role)->random();
        return [
            "name" => $role,
            "description" => $this->faker->text(),
            "slug" => $this->faker->slug(),
            "user_id" => User::all()->random()->id,
        ];
    }
}
