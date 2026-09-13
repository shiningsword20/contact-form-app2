<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function お問い合わせは1つのカテゴリに属する(): void
    {
        // Arrange（準備）：カテゴリと、それに紐づくContactを作成する
        $category = Category::factory()->create();
        $contact = Contact::factory()->create(['category_id' => $category->id]);

        // Act（実行）：$contact->categoryで取得する
        $contacts = $contact->category;

        // Assert（検証）：取得したカテゴリが正しいか確認する
        $this->assertEquals($category->id, $contacts->id);
    }

    /** @test */
    public function お問い合わせに複数のタグを同期できる(): void
    {
        // Arrange（準備）：Contactと、複数のTagを作成する
        $category = Category::factory()->create();
        $tag1 = Tag::factory()->create(['name' => '質問']);
        $tag2 = Tag::factory()->create(['name' => '要望']);
        $tag3 = Tag::factory()->create(['name' => '不具合報告']);
        $contact = Contact::factory()->create(['category_id' => $category->id]);

        // Act（実行）：$contact->tags()->sync([...])でタグを同期する
        $contact->tags()->sync([$tag1->id, $tag2->id, $tag3->id]);

        // Assert（検証）：$contact->tagsで正しく紐づいているか確認する
        $this->assertCount(3, $contact->tags);
    }
}
