<?php

namespace Tests\Unit\Models;

use App\Models\Blog\BlogAuthor;
use App\Models\Blog\BlogPost;
use App\Traits\HasSlug;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BlogPostModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_uses_has_slug_trait()
    {
        $this->assertContains(HasSlug::class, class_uses(BlogPost::class));
    }

    #[Test]
    public function it_has_fillable_attributes()
    {
        $post = new BlogPost();
        
        $this->assertEquals([
            'author_id',
            'blog_post_name',
            'blog_post_content',
            'blog_post_type',
            'thumbnail_path',
            'slug',
            'blog_post_url',
            'created_at',
            'updated_at'
        ], $post->getFillable());
    }

    #[Test]
    public function it_has_author_relationship()
    {
        $author = BlogAuthor::factory()->create();
        $post = BlogPost::factory()->create(['author_id' => $author->id]);

        $this->assertInstanceOf(BlogAuthor::class, $post->author);
        $this->assertEquals($author->id, $post->author->id);
        $this->assertEquals('author_id', $post->author()->getForeignKeyName());
    }

    #[Test]
    public function it_can_be_created_with_all_fields()
    {
        $post = BlogPost::factory()->create();

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'blog_post_name' => $post->blog_post_name,
            'slug' => $post->slug,
        ]);
    }

    #[Test]
    public function it_handles_blog_post_types_correctly()
    {
        $validTypes = ['Poradnik', 'Trendy', 'Marketing', 'Technologia', 'Za Kulisami', 'Życiowe', 'Podsumowanie', 'Top 10', 'Brak'];
        
        foreach ($validTypes as $type) {
            $post = BlogPost::factory()->create(['blog_post_type' => $type]);
            $this->assertEquals($type, $post->blog_post_type);
        }
    }

    #[Test]
    public function it_has_timestamps()
    {
        $post = BlogPost::factory()->create();
        
        $this->assertNotNull($post->created_at);
        $this->assertNotNull($post->updated_at);
    }
}