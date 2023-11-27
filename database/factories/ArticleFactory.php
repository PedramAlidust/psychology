<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
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
            'description1' => $this->faker->unique()->sentence(2), 
            'description2' => $this->faker->unique()->sentence(2),
            'description3' => $this->faker->unique()->sentence(2), 
            'description4' => $this->faker->unique()->sentence(2), 
            'description5' => $this->faker->unique()->sentence(2), 
            'description6' => $this->faker->unique()->sentence(2), 
            'content_image1' => $this->faker->imageUrl(640, 480),
            'content_image2' => $this->faker->imageUrl(640, 480), 
            'content_image3' => $this->faker->imageUrl(640, 480), 
            'content_image4' => $this->faker->imageUrl(640, 480), 
            'content_image5' => $this->faker->imageUrl(640, 480), 
            'content_image6' => $this->faker->imageUrl(640, 480), 
            'source' => $this->faker->url(),
            'featured_image' => $this->faker->imageUrl(640, 480), 
            'categorie' => $this->faker->name(), 
        ];
    } 
}
