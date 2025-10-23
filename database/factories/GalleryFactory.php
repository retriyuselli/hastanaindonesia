<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Resepsi',
            'Akad Nikah',
            'Outdoor Wedding',
            'Dekorasi',
            'Behind The Scenes',
            'Fashion',
            'Planning',
            'Catering',
            'Entertainment',
            'Technical',
            'Preparation',
            'Intimate Wedding',
        ];

        $locations = [
            'Jakarta',
            'Bandung',
            'Surabaya',
            'Bali',
            'Yogyakarta',
            'Semarang',
            'Medan',
            'Makassar',
            'Solo',
            'Lombok',
        ];

        $category = fake()->randomElement($categories);
        
        $titles = [
            'Resepsi' => 'Setup Ballroom Mewah',
            'Akad Nikah' => 'Akad Nikah Tradisional',
            'Outdoor Wedding' => 'Garden Wedding Ceremony',
            'Dekorasi' => 'Dekorasi Venue Elegan',
            'Behind The Scenes' => 'Behind The Scenes Setup',
            'Fashion' => 'Busana Pengantin Tradisional',
            'Planning' => 'Sesi Konsultasi Wedding',
            'Catering' => 'Wedding Cake Design',
            'Entertainment' => 'Live Music Entertainment',
            'Technical' => 'Lighting & Sound Setup',
            'Preparation' => 'Bride Preparation',
            'Intimate Wedding' => 'Intimate Gathering',
        ];

        $images = [
            'Resepsi' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&h=800&fit=crop',
            'Akad Nikah' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
            'Outdoor Wedding' => 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&h=800&fit=crop',
            'Dekorasi' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=800&h=800&fit=crop',
            'Behind The Scenes' => 'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=800&h=800&fit=crop',
            'Fashion' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=800&h=800&fit=crop',
            'Planning' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=800&h=800&fit=crop',
            'Catering' => 'https://images.unsplash.com/photo-1535254973040-607b474cb50d?w=800&h=800&fit=crop',
            'Entertainment' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&h=800&fit=crop',
            'Technical' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800&h=800&fit=crop',
            'Preparation' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&h=800&fit=crop',
            'Intimate Wedding' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&h=800&fit=crop',
        ];

        return [
            'title' => $titles[$category] . ' ' . fake()->numberBetween(1, 100),
            'description' => fake()->paragraph(3),
            'image' => $images[$category],
            'category' => $category,
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'location' => fake()->randomElement($locations),
            'photographer' => 'HASTANA Photography Team',
            'wedding_organizer_id' => null, // Will be set in seeder if needed
            'views_count' => fake()->numberBetween(0, 1000),
            'is_featured' => fake()->boolean(20), // 20% chance of being featured
            'is_published' => fake()->boolean(90), // 90% chance of being published
            'tags' => fake()->randomElements(['wedding', 'pernikahan', 'dekorasi', 'elegant', 'modern', 'traditional'], fake()->numberBetween(2, 4)),
        ];
    }

    /**
     * Indicate that the gallery is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the gallery is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the gallery is unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
