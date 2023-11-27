<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Therapist>
 */
class TherapistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(), 
            'treatment_fields' => json_encode([
                'field1' => $this->faker->word(), 
                'field2' => $this->faker->word(), 
                'field3' => $this->faker->word()
            ]),
            'education'  => $this->faker->unique()->sentence(2), 
            'description' => $this->faker->unique()->sentence(2),
            'phone_number' => $this->faker->phoneNumber(), 
            'price' => $this->faker->randomFloat(2, 10, 1000),             
            'work_experience' => $this->faker->numberBetween(0, 20) 
        ];
    }
}
