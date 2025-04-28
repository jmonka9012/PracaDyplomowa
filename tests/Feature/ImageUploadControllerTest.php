<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ImageUploadControllerTest extends TestCase
{
    protected User $adminUser;
    protected User $moderatorUser;
    protected User $redactorUser;
    protected User $blogAuthorUser;
    protected User $organizerUser;
    protected User $regularUser;
    protected User $regularUnverifiedUser;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        
        $this->adminUser = User::factory()->create(['role' => 'admin']);
        $this->regularUser = User::factory()->create(['role' => 'verified_user']);      
    }

    #[Test]
    public function it_rejects_unauthenticated_users()
    {
        $response = $this->postJson(route('event-create.image'));
        $response->assertUnauthorized();
    }

    #[Test]
    public function it_rejects_non_admin_users()
    {
            $response = $this->actingAs($this->regularUser)
                ->postJson(route('event-create.image'));
                
            $response->assertForbidden();
    }

    #[Test]
    public function it_stores_event_images_correctly_for_admins()
    {
        $file = UploadedFile::fake()->image('event-image.jpg');

        $response = $this->actingAs($this->adminUser)
            ->postJson(route('event-create.image'), [
                'image' => $file
            ]);

        $response->assertOk()
            ->assertJsonStructure(['location']);

        $year = date('Y');
        $month = date('m');
        $expectedPath = "wysywig-events/{$year}/{$month}/".time().'_event-image.jpg';

        Storage::disk('public')->assertExists($expectedPath);
    }

    #[Test]
    public function it_stores_blog_images_correctly_for_admins()
    {
        $file = UploadedFile::fake()->image('blog-image.jpg');

        $response = $this->actingAs($this->adminUser)
            ->postJson(route('blog-create.image'), [
                'image' => $file
            ]);

        $response->assertOk()
            ->assertJsonStructure(['location']);

        $year = date('Y');
        $month = date('m');
        $expectedPath = "wysywig-blog/{$year}/{$month}/".time().'_blog-image.jpg';

        Storage::disk('public')->assertExists($expectedPath);
    }

    #[Test]
    public function it_validates_image_upload_for_admins()
    {
        $invalidFile = UploadedFile::fake()->create('document.pdf', 1000);

        $response = $this->actingAs($this->adminUser)
            ->postJson(route('event-create.image'), [
                'image' => $invalidFile
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['image']);

        $largeFile = UploadedFile::fake()->image('large.jpg')->size(3000);

        $response = $this->actingAs($this->adminUser)
            ->postJson(route('event-create.image'), [
                'image' => $largeFile
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['image']);
    }

    #[Test]
    public function it_returns_correct_public_url_for_admins()
    {
        $file = UploadedFile::fake()->image('test-image.jpg');

        $response = $this->actingAs($this->adminUser)
            ->postJson(route('event-create.image'), [
                'image' => $file
            ]);

        $responseData = $response->json();
        $this->assertStringContainsString(
            'storage/wysywig-events',
            $responseData['location']
        );
        $this->assertStringEndsWith(
            'test-image.jpg',
            $responseData['location']
        );
    }
}