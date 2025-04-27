<?php

namespace Tests\Unit\Enums;

use App\Enums\UserRole;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UserRoleEnumTest extends TestCase
{
    #[DataProvider('rolePermissionLevelProvider')]
    public function test_permission_levels(UserRole $role, int $expectedLevel): void
    {
        $this->assertSame($expectedLevel, $role->permissionLevel());
    }

    #[DataProvider('rolePermissionLabelProvider')]
    public function test_permission_labels(UserRole $role, string $expectedLabel): void
    {
        $this->assertSame($expectedLabel, $role->permissionLabel());
    }

    public static function rolePermissionLevelProvider(): array
    {
        return [
            'Admin' => [UserRole::ADMIN, 0],
            'Moderator' => [UserRole::MODERATOR, 1],
            'Redactor' => [UserRole::REDACTOR, 2],
            'Blog Author' => [UserRole::BLOG_AUTHOR, 3],
            'Organizer' => [UserRole::ORGANIZER, 4],
            'Verified User' => [UserRole::VERIFIED_USER, 6],
            'Unverified User' => [UserRole::UNVERIFIED_USER, 8],
            'Guest' => [UserRole::GUEST, 10],
        ];
    }

    public static function rolePermissionLabelProvider(): array
    {
        return [
            'Admin' => [UserRole::ADMIN, 'admin'],
            'Moderator' => [UserRole::MODERATOR, 'moderator'],
            'Redactor' => [UserRole::REDACTOR, 'redactor'],
            'Blog Author' => [UserRole::BLOG_AUTHOR, 'blog_author'],
            'Organizer' => [UserRole::ORGANIZER, 'organizer'],
            'Verified User' => [UserRole::VERIFIED_USER, 'verified_user'],
            'Unverified User' => [UserRole::UNVERIFIED_USER, 'unverified_user'],
            'Guest' => [UserRole::GUEST, 'guest'],
        ];
    }

    public function test_all_enum_cases_are_tested_for_levels(): void
    {
        $testedCases = array_map(
            fn ($data) => $data[0],
            $this->rolePermissionLevelProvider()
        );
        
        $this->assertSameSize(UserRole::cases(), $testedCases);
    }

    public function test_all_enum_cases_are_tested_for_labels(): void
    {
        $testedCases = array_map(
            fn ($data) => $data[0],
            $this->rolePermissionLabelProvider()
        );
        
        $this->assertSameSize(UserRole::cases(), $testedCases);
    }
}