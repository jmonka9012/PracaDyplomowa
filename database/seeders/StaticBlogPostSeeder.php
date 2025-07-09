<?php

namespace Database\Seeders;

use App\Models\Blog\BlogPost;
use Illuminate\Database\Seeder;
use App\Models\Blog\BlogAuthor;


class StaticBlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogContent =
        '<p><img src="/storage/event_images/placeholder.jpg"></p>
        <hr>
        <div class="single-info" id="Content">
        <div id="bannerL">
        <div id="lipsumcom_left_siderail_1" align="center" data-google-query-id="COrJj9r40owDFZ3MOwIdsHAG1w" data-freestar-ad="__300x600 __400x225"></div>
        <div id="lipsumcom_left_siderail_2" align="center" data-freestar-ad="__300x600"></div>
        </div>
        <div id="bannerR">
        <div id="lipsumcom_right_siderail_1" align="center" data-google-query-id="COvJj9r40owDFZ3MOwIdsHAG1w" data-freestar-ad="__300x600 __400x225"></div>
        <div id="lipsumcom_right_siderail_2" align="center" data-freestar-ad="__300x600"></div>
        </div>
        <div>
        <div id="lipsum">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pellentesque massa eu leo dictum, vel condimentum diam volutpat. Aenean eu porttitor massa, quis malesuada tellus. Vestibulum lobortis, ex ac sagittis consequat, sapien risus mattis ante, ut pretium eros urna eu sapien. Vivamus eu mollis nunc, quis iaculis nunc. Donec semper purus diam, consectetur porttitor justo pretium in. Pellentesque dictum dui at ipsum consequat, a convallis enim mollis. Etiam facilisis blandit turpis, varius rutrum lorem rutrum vitae. Quisque a massa consequat, congue risus a, rutrum dolor.</p>
        <p>Quisque ut lorem nisi. Vestibulum ornare a dolor sollicitudin consequat. Ut ornare eleifend arcu in finibus. Cras sed efficitur nisl, quis tempor urna. Curabitur tellus ipsum, mollis vitae ex ut, ultrices vestibulum massa. Suspendisse non magna eget augue porta dignissim id eget neque. Duis eget sollicitudin velit, vitae posuere dui. Etiam tincidunt facilisis ipsum eu faucibus. Proin posuere, mauris in imperdiet venenatis, purus augue elementum nibh, quis tempor ante lorem at libero. In hac habitasse platea dictumst. Aenean porttitor iaculis augue non sagittis. Donec placerat faucibus metus eget cursus. Integer eu luctus quam. Vestibulum sollicitudin at sem auctor aliquet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum lobortis, turpis sed placerat blandit, dui nulla accumsan felis, vel dignissim nisi est et risus.</p>
        </div>
        </div>
        </div>';

        $imagePath = 'event_images/placeholder.jpg';
        $authorId = BlogAuthor::first()->id;
        
        $blogPosts=[
            [
                'author_id' => $authorId,
                'blog_post_name' => 'Muzyka Metalowa w 2025',
                'blog_post_content' => $blogContent,
                'thumbnail_path' => $imagePath,
                'created_at' =>  now()->addDays(1),
                'blog_post_type' => 'Trendy'
            ],
            [
                'author_id' => $authorId,
                'blog_post_name' => 'Nowe mikrofony',
                'blog_post_content' => $blogContent,
                'thumbnail_path' => $imagePath,
                'created_at' =>  now()->addDays(2),
                'blog_post_type' => 'Technologia'
            ],
            [
                'author_id' => $authorId,
                'blog_post_name' => 'Najlepsze słuchawki do słuchania muzyki',
                'blog_post_content' => $blogContent,
                'thumbnail_path' => $imagePath,
                'created_at' =>  now()->addDays(3),
                'blog_post_type' => 'Technologia'
            ],
            [
                'author_id' => $authorId,
                'blog_post_name' => 'Jak sprzedać swoje bilety',
                'blog_post_content' => $blogContent,
                'thumbnail_path' => $imagePath,
                'created_at' =>  now()->addDays(4),
                'blog_post_type' => 'Marketing'
            ],
            [
                'author_id' => $authorId,
                'blog_post_name' => 'Najbardziej popularne gatunki muzyki 2025',
                'blog_post_content' => $blogContent,
                'thumbnail_path' => $imagePath,
                'created_at' =>  now()->addDays(5),
                'blog_post_type' => 'Trendy'
            ],
            [
                'author_id' => $authorId,
                'blog_post_name' => 'Gdzie zacząć naukę gry na gitarze',
                'blog_post_content' => $blogContent,
                'thumbnail_path' => $imagePath,
                'created_at' =>  now()->addDays(6),
                'blog_post_type' => 'Poradnik'
            ],
        ];

        foreach($blogPosts as $blogData) {
            BlogPost::create($blogData);
        };
    }
}
