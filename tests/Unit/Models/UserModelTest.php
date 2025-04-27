<?php

namespace Tests\Unit\Models;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    #[DataProvider('userRoleProvider')]
    public function test_role_casting_works_correctly(UserRole $role): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->assertInstanceOf(UserRole::class, $user->role);
        $this->assertEquals($role, $user->role);
    }

    public function test_password_is_automatically_hashed(): void
    {
        $password = 'secret';
        $user = User::factory()->create(['password' => $password]);

        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(password_verify($password, $user->password));
    }

    #[DataProvider('permissionLevelProvider')]
    public function test_get_permission_level_returns_correct_value(UserRole $role, int $expectedLevel): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->assertEquals($expectedLevel, $user->getPermissionLevel());
    }

    public function test_hidden_fields_are_not_serialized(): void
    {
        $user = User::factory()->create();
        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    public function test_fillable_fields_are_mass_assignable(): void
    {
        $now = now();
        $data = [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email_verified_at' => $now,
        ];
    
        $user = User::create($data);
    
        foreach ($data as $key => $value) {
            if ($key === 'password') {
                continue;
            }
            
            if ($key === 'email_verified_at') {
                $this->assertEquals(
                    $value->format('Y-m-d H:i:s'), 
                    $user->$key->format('Y-m-d H:i:s')
                );
            } else {
                $this->assertEquals($value, $user->$key);
            }
        }
    }

    public static function userRoleProvider(): array
    {
        return array_map(
            fn($role) => [$role],
            UserRole::cases()
        );
    }

    public static function permissionLevelProvider(): array
    {
        return [
            [UserRole::ADMIN, 0],
            [UserRole::MODERATOR, 1],
            [UserRole::REDACTOR, 2],
            [UserRole::BLOG_AUTHOR, 3],
            [UserRole::ORGANIZER, 4],
            [UserRole::VERIFIED_USER, 6],
            [UserRole::UNVERIFIED_USER, 8],
            [UserRole::GUEST, 10],
        ];
    }
}

//todo @Yen1312: author relationship, ticket relationship