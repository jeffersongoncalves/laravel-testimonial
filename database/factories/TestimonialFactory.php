<?php

namespace JeffersonGoncalves\Testimonial\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JeffersonGoncalves\Testimonial\Models\Testimonial;

/** @extends Factory<Testimonial> */
class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role' => fake()->jobTitle(),
            'company' => fake()->company(),
            'avatar' => null,
            'content' => ['en' => fake()->paragraph()],
            'rating' => fake()->numberBetween(1, 5),
            'order' => 0,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
