<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courses = [
            "Vue js", "React Js", "PHP", "Mysql", "Laravel", "Node Js",
            "Python", "Django", "Java", "C++", "C#"
        ];

        return [
            "name" => collect($courses)->random(),
            "time" => json_encode([
                "start" => $this->faker->time(),
                "end" => $this->faker->time()
            ]),
            "start_date" => $this->faker->date(),
            "end_date" => $this->faker->date(),
            "description" => $this->faker->text()
        ];
    }
}
