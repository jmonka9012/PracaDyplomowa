<?php

namespace Tests\Unit\Models\Blog;

use App\Models\Blog\BlogAuthor;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BlogAuthorModelTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function it_can_be_created_with_fillable_attributes()
    {
        $author = BlogAuthor::create([
            'user_id' => $this->user->id,
            'author_image_path' => 'images/authors/author1.jpg',
            'about_me' => 'About the author',
        ]);

        $this->assertDatabaseHas('blog_authors', [
            'id' => $author->id,
            'user_id' => $this->user->id,
            'author_image_path' => 'images/authors/author1.jpg',
            'about_me' => 'About the author',
        ]);
    }

    #[Test]
    public function it_has_a_user_relationship()
    {
        $author = BlogAuthor::create([
            'user_id' => $this->user->id,
            'author_image_path' => 'path/to/image.jpg',
            'about_me' => 'Test about me',
        ]);

        $this->assertInstanceOf(User::class, $author->user);
        $this->assertEquals($this->user->id, $author->user->id);
    }

    #[Test]
    public function it_has_posts_relationship()
    {
        $author = BlogAuthor::create([
            'user_id' => $this->user->id,
            'author_image_path' => 'path/to/image.jpg',
            'about_me' => 'Test about me',
        ]);

        $post = BlogPost::create([
            'author_id' => $author->id,
            'blog_post_name' => 'Test Post',
            'blog_post_content' => 'Test content',
            'blog_post_type' => 'Poradnik',
        ]);

        $this->assertTrue($author->posts->contains($post));
        $this->assertInstanceOf(BlogPost::class, $author->posts->first());
        $this->assertEquals('author_id', $author->posts()->getForeignKeyName());
    }

    #[Test]
    public function it_has_fillable_attributes()
    {
        $author = new BlogAuthor();
        
        $this->assertEquals([
            'user_id',
            'author_image_path',
            'about_me',
            'created_at',
            'updated_at'
        ], $author->getFillable());
    }

    #[Test]
    public function it_has_timestamps()
    {
        $author = BlogAuthor::create([
            'user_id' => $this->user->id,
            'author_image_path' => 'path/to/image.jpg',
            'about_me' => 'Test about me',
        ]);
        
        $this->assertNotNull($author->created_at);
        $this->assertNotNull($author->updated_at);
    }
}