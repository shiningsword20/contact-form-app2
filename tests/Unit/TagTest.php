<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function タグは複数のお問い合わせに紐づく(): void
    {
        // Arrange（準備）：カテゴリ・Tag・複数のContactを作成し、sync()で紐づける
        $tag = Tag::factory()->create();
        $category = Category::factory()->create();
        $contact1 = Contact::factory()->create(['category_id' => $category->id]);
        $contact2 = Contact::factory()->create(['category_id' => $category->id]);
        $contact3 = Contact::factory()->create(['category_id' => $category->id]);

        // Act（実行）：$tag->contactsで取得する
        $tag->contacts()->sync([$contact1->id, $contact3->id, $contact2->id]);

        // Assert（検証）：件数を確認する
        $this->assertCount(3, $tag->contacts);
    }
}
