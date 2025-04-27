<?php

namespace Database\Seeders;

use App\Models\Blog\BlogPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog\BlogAuthor;
use Illuminate\Validation\Rules\Exists;
use Faker\Factory as Faker;


class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $authorId = BlogAuthor::first()->id;
        
        $postTypes = ['Poradnik', 'Trendy', 'Marketing', 'Technologia', 'Życiowe', 'Podsumowanie', 'Top 10', 'Brak'];
        $titlePrefixes = [
            'About Lore Ipsums',
            'The Complete Guide to',
            'Understanding',
            'Advanced Techniques for',
            'Everything About',
            'Secrets of',
            'Mastering',
            'Beginner\'s Guide to'
        ];
        $titleTopics = [
            'Content Creation',
            'Digital Marketing',
            'Web Development',
            'Prompt Engineering',
            'Social Media',
            'SEO Strategies',
            'Programming',
            'Business Growth',
            'Brain Rot'
        ];

        for ($i = 0; $i < 100; $i++) {
            BlogPost::create([
                'author_id' => $authorId,
                'blog_post_name' => $faker->randomElement($titlePrefixes) . ' ' . 
                                    $faker->randomElement($titleTopics) . ' ' .
                                    $faker->randomElement(['', 'Part 1', 'Part 2', '2024 Edition']),
                'blog_post_content' => $this->generateBlogContent($faker),
                'thumbnail_path' => 'event_images/placeholder.jpg',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'blog_post_type' => $faker->randomElement($postTypes),
            ]);
        }
    }

    protected function generateBlogContent($faker): string
    {
        return '<p><img src="/storage/event_images/placeholder.jpg"></p>
                <hr>
                <div class="single-info" id="Content">
                <div>
                <div id="lipsum">
                <p>'.$faker->paragraph(6).'</p>
                <p>'.$faker->paragraph(8).'</p>
                </div>
                </div>
                </div>';
    }
}
