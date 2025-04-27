<?php

namespace Tests\Unit\Enums;

use App\Enums\BlogPostType;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class BlogPostTypeTest extends TestCase
{
    #[DataProvider('blogPostTypeValuesProvider')]
    public function test_enum_has_correct_values(BlogPostType $type, string $expectedValue): void
    {
        $this->assertSame($expectedValue, $type->value);
    }

    public static function blogPostTypeValuesProvider(): array
    {
        return [
            'GUIDE' => [BlogPostType::GUIDE, 'Poradnik'],
            'TRENDS' => [BlogPostType::TRENDS, 'Trendy'],
            'MARKETING' => [BlogPostType::MARKETING, 'Marketing'],
            'TECHNOLOGY' => [BlogPostType::TECHNOLOGY, 'Technologia'],
            'BEHIND_THE_SCENES' => [BlogPostType::BEHIND_THE_SCENES, 'Za Kulisami'],
            'LIFESTYLE' => [BlogPostType::LIFESTYLE, 'Życiowe'],
            'SUMMARY' => [BlogPostType::SUMMARY, 'Podsumowanie'],
            'TOP10' => [BlogPostType::TOP10, 'Top 10'],
            'NONE' => [BlogPostType::NONE, 'Brak'],
        ];
    }

    #[DataProvider('blogPostTypeCasesProvider')]
    public function test_values_method_returns_correct_values(BlogPostType $case): void
    {
        $values = BlogPostType::values();
        $this->assertContains($case->value, $values);
    }

    public static function blogPostTypeCasesProvider(): array
    {
        return array_map(
            fn($case) => [$case],
            BlogPostType::cases()
        );
    }

    public function test_values_method_returns_all_values(): void
    {
        $expectedValues = [
            'Poradnik',
            'Trendy',
            'Marketing',
            'Technologia',
            'Za Kulisami',
            'Życiowe',
            'Podsumowanie',
            'Top 10',
            'Brak',
        ];

        $this->assertSame($expectedValues, BlogPostType::values());
    }

    public function test_all_cases_are_tested(): void
    {
        $testedCases = array_map(
            fn($data) => $data[0],
            self::blogPostTypeValuesProvider()
        );
        
        $this->assertSameSize(BlogPostType::cases(), $testedCases);
    }
}