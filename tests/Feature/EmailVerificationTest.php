<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\VerifyEmail;
use PHPUnit\Framework\Attributes\Test;
class EmailVerificationTest extends TestCase
{
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new EmailVerificationController();
    }

    #[Test]
    public function show_redirects_to_my_account()
    {
        $request = Request::create('/email/verify', 'GET');
        $response = $this->controller->show($request);
        
        $this->assertEquals(route('my-account'), $response->getTargetUrl());
    }

    #[Test]
    public function verify_updates_user_and_redirects_on_valid_signature()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'role' => UserRole::UNVERIFIED_USER,
            'permission_level' => UserRole::UNVERIFIED_USER->permissionLevel()
        ]);

        $url = URL::temporarySignedRoute(
            'verification.verify', now()->addMinutes(60), ['id' => $user->id]
        );
        $request = Request::create($url);

        $response = $this->controller->verify($request, $user->id);

        $user->refresh();

        $this->assertNotNull($user->email_verified_at);
        $this->assertInstanceOf(UserRole::class, $user->role);
        $this->assertEquals(UserRole::VERIFIED_USER, $user->role);
        $this->assertEquals(UserRole::VERIFIED_USER->permissionLevel(), $user->permission_level);
        $this->assertEquals(route('my-account'), $response->getTargetUrl());
        $this->assertEquals('Email zweryfikowany', $response->getSession()->get('status'));
    }


    #[Test]
    public function verify_aborts_on_invalid_signature()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Link wygasł, poproś o nowy link w zakładzce Moje Konto');

        $user = User::factory()->create();
        $request = Request::create('/invalid-url', 'GET');
        
        $this->controller->verify($request, $user->id);
    }

    #[Test]
    public function resend_sends_email_and_redirects_for_unverified_user()
    {
        Mail::fake();
        
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);
        
        $request = Request::create('/email/resend', 'POST');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        
        $response = $this->controller->resend($request);
        
        Mail::assertSent(VerifyEmail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        
        $this->assertEquals(back()->getTargetUrl(), $response->getTargetUrl());
        $this->assertEquals('Email został wysłany', $response->getSession()->get('status'));
    }

    #[Test]
    public function resend_redirects_for_verified_user()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);
        
        $request = Request::create('/email/resend', 'POST');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        
        $response = $this->controller->resend($request);
        
        $this->assertEquals(route('my-account'), $response->getTargetUrl());
    }
}