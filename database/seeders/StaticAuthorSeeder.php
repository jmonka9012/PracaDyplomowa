<?php

namespace Database\Seeders;

use App\Models\Blog\BlogAuthor;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaticAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'blog_author')->get();
    
        foreach ($users as $user) {
            BlogAuthor::create([
                'user_id' => $user->id,
                'author_image_path' => 'event_images/placeholder.jpg',
                'about_me' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam eget nulla ipsum. Ut molestie sapien id ante semper suscipit. Integer eget ex vel nisl scelerisque blandit eget non arcu. Sed aliquet, ex ut egestas aliquam, libero mauris porttitor lacus, vel feugiat lacus massa ac mauris.'
            ]);
        }
    }
    
}
