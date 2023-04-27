<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::query()->insert([
            ['name' => 'admin', 'description' => 'Administrator', 'slug' => 'admin'],
            ['name' => 'teacher', 'description' => 'Teacher', 'slug' => 'teacher'],
            ['name' => 'student', 'description' => 'Student', 'slug' => 'student'],
        ]);

        \App\Models\User::factory(40)->create();

        User::query()->first()->update([
            'name' => 'Admin',
            'role_id' => Role::ADMIN,
            'email' => 'admin@mail.com'
        ]);

        Course::factory(4)->create();

        Student::all()->each(function ($student) {
            $student->courses()->attach(
                Course::all()->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
