<?php

namespace Tests\Unit\Models;

use App\Models\Blog\BlogAuthor;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BlogAuthorModelTest extends TestCase
{
    use DatabaseTransactions;

    protected User $user;
    protected BlogAuthor $author;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->author = BlogAuthor::factory()->create(['user_id' => $this->user->id]);
    }

    #[Test]
    public function it_can_be_created_with_fillable_attributes()
    {
        $this->assertDatabaseHas('blog_authors', [
            'id' => $this->author->id,
            'user_id' => $this->user->id,
            'author_image_path' => $this->author->author_image_path,
            'about_me' => $this->author->about_me,
        ]);
    }

    #[Test]
    public function it_has_a_user_relationship()
    {
        $this->assertInstanceOf(User::class, $this->author->user);
        $this->assertEquals($this->user->id, $this->author->user->id);
    }

    #[Test]
    public function it_has_posts_relationship()
    {
        $post = BlogPost::factory()->create(['author_id' => $this->author->id]);

        $this->assertTrue($this->author->posts->contains($post));
        $this->assertInstanceOf(BlogPost::class, $this->author->posts->first());
        $this->assertEquals('author_id', $this->author->posts()->getForeignKeyName());
    }

    #[Test]
    public function it_has_fillable_attributes()
    {
        $fillable = [
            'user_id',
            'author_image_path',
            'about_me',
            'created_at',
            'updated_at'
        ];
        
        $this->assertEquals($fillable, (new BlogAuthor())->getFillable());
    }

    #[Test]
    public function it_has_timestamps()
    {
        $this->assertNotNull($this->author->created_at);
        $this->assertNotNull($this->author->updated_at);
    }

    #[Test]
    public function it_uses_factory_states_correctly()
    {
        $customAbout = 'Custom about me text';
        $author = BlogAuthor::factory()
            ->withAboutMe($customAbout)
            ->create();

        $this->assertEquals($customAbout, $author->about_me);
    }
}