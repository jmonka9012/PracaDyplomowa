<?php

namespace Database\Factories\Blog;

use App\Models\Blog\BlogAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogAuthorFactory extends Factory
{
    protected $model = BlogAuthor::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'author_image_path' => $this->faker->imageUrl(400, 400, 'people', true),
            'about_me' => $this->faker->paragraphs(3, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function withSpecificUser(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    public function withAboutMe(string $text)
    {
        return $this->state([
            'about_me' => $text,
        ]);
    }

    public function withImage(string $path)
    {
        return $this->state([
            'author_image_path' => $path,
        ]);
    }
}