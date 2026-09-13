<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function カテゴリは複数のお問い合わせを持つ(): void
    {
        // Arrange（準備）：カテゴリと、それに紐づくContactを複数作成する
        $category = Category::factory()->create();
        Contact::factory()->count(10)->create(['category_id' => $category->id]);

        // Act（実行）：$category->contactsで取得する
        $contacts = $category->contacts;

        // Assert（検証）：件数や中身を確認する
        $this->assertCount(10, $contacts);
    }
}
