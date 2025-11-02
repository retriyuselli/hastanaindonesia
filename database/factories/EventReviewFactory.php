<?php

namespace Database\Factories;

use App\Models\EventHastana;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventReview>
 */
class EventReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rating = fake()->numberBetween(1, 5);
        $wouldRecommend = $rating >= 4;
        
        return [
            'event_hastana_id' => EventHastana::inRandomOrder()->first()?->id ?? EventHastana::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'event_participant_id' => fake()->boolean(60) ? (EventParticipant::inRandomOrder()->first()?->id ?? null) : null,
            'rating' => $rating,
            'title' => fake()->sentence(rand(3, 8)),
            'review' => fake()->paragraphs(rand(2, 4), true),
            'pros' => fake()->boolean(70) ? fake()->paragraph() : null,
            'cons' => fake()->boolean(30) ? fake()->paragraph() : null,
            'would_recommend' => $wouldRecommend,
            'is_verified_participant' => fake()->boolean(60),
            'is_approved' => fake()->boolean(85), // 85% approved
            'is_featured' => fake()->boolean(15), // 15% featured
            'helpful_count' => fake()->numberBetween(0, 50),
            'reported_count' => fake()->numberBetween(0, 3),
            'moderator_notes' => fake()->boolean(10) ? fake()->sentence() : null,
            'ip_address' => fake()->ipv4(),
        ];
    }

    /**
     * Indicate that the review is verified participant.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified_participant' => true,
            'is_approved' => true, // Auto-approve verified participants
            'event_participant_id' => EventParticipant::inRandomOrder()->first()?->id ?? EventParticipant::factory(),
        ]);
    }

    /**
     * Indicate that the review is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_approved' => true,
            'rating' => fake()->numberBetween(4, 5), // Featured reviews are usually positive
        ]);
    }

    /**
     * Indicate that the review is pending approval.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }

    /**
     * Indicate that the review has high rating.
     */
    public function highRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(4, 5),
            'would_recommend' => true,
        ]);
    }

    /**
     * Indicate that the review has low rating.
     */
    public function lowRating(): static
    {
        return $this->state(fn (array $attributes) => [
            'rating' => fake()->numberBetween(1, 2),
            'would_recommend' => false,
            'cons' => fake()->paragraphs(2, true),
        ]);
    }
}
