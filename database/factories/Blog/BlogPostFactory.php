<?php

namespace Database\Factories\Blog;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog\BlogAuthor;
use App\Models\Blog\BlogPost;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition()
    {
        $types = ['Poradnik', 'Trendy', 'Marketing', 'Technologia', 'Za Kulisami', 'Życiowe', 'Podsumowanie', 'Top 10', 'Brak'];
        
        return [
            'author_id' => BlogAuthor::factory(),
            'blog_post_name' => $this->faker->sentence(4),
            'slug' => $this->faker->slug,
            'blog_post_url' => $this->faker->url,
            'blog_post_content' => $this->faker->paragraphs(3, true),
            'blog_post_type' => $this->faker->randomElement($types),
            'thumbnail_path' => $this->faker->imageUrl(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}