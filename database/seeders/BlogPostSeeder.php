<?php

namespace Database\Seeders;

use App\Models\Blog\BlogPost;
use Illuminate\Database\Seeder;
use App\Models\Blog\BlogAuthor;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authorId = BlogAuthor::first()->id;
        
        $postTypes = ['Poradnik', 'Trendy', 'Marketing', 'Technologia', 'Życiowe', 'Podsumowanie', 'Top 10', 'Brak'];
        $titlePrefixes = [
            'O muzyce',
            'Czemu dobrym pomysłem jest :',
            'Zrozumienie',
            'Po co nam ',
            'Top 10',
            'O muzykach ',
            'Nadchodzące koncerty ',
        ];
        $titleTopics = [
            'Metalowej',
            'Pop',
            'Rock',
            'Organizatorzy',
            'Media społecznościowe',
            'Przykładowe',
            'Coś',
            'Polska',
            'Tanie'
        ];

        BlogPost::factory()
            ->count(100)
            ->create([
                'author_id' => $authorId,
            ])
            ->each(function ($post) use ($titlePrefixes, $titleTopics, $postTypes) {
                $post->update([
                    'blog_post_name' => fake()->randomElement($titlePrefixes) . ' ' . 
                                        fake()->randomElement($titleTopics) . ' ' .
                                        fake()->randomElement(['', 'Cześć 1', 'Część 2', '2025']),
                    'blog_post_content' => $this->generateBlogContent(),
                    'thumbnail_path' => 'event_images/placeholder.jpg',
                    'blog_post_type' => fake()->randomElement($postTypes),
                ]);
            });
    }

    protected function generateBlogContent(): string
    {
        return '<p><img src="/storage/event_images/placeholder.jpg"></p>
                <hr>
                <div class="single-info" id="Content">
                <div>
                <div id="lipsum">
                <p>'.fake()->paragraph(6).'</p>
                <p>'.fake()->paragraph(8).'</p>
                </div>
                </div>
                </div>';
    }
}