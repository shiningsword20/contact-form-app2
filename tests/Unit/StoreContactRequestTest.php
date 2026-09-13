<?php

namespace Tests\Unit;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreContactRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正しい問い合わせ内容はバリデーションを通過する(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        $category = Category::factory()->create();
        $tag1 = Tag::factory()->create(['name' => '質問']);
        $tag2 = Tag::factory()->create(['name' => '要望']);
        $rules = (new StoreContactRequest)->rules();
        $data = [
            'first_name' => '杉林',
            'last_name' => '由樹',
            'gender' => 1,
            'email' => 'test2@example.com',
            'tel' => '09012345678',
            'address' => '愛知県名古屋市',
            'building' => 'バステール303',
            'category_id' => $category->id,
            'detail' => '商品の配送状況について教えてください。発送はいつ頃になりますでしょうか。',
            'tag_ids' => [$tag1->id, $tag2->id],
        ];
        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：passes()で通過を確認する
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function 不正な電話番号の形式はバリデーションを通過しない(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        $category = Category::factory()->create();
        $tag1 = Tag::factory()->create(['name' => '質問']);
        $tag2 = Tag::factory()->create(['name' => '要望']);
        $rules = (new StoreContactRequest)->rules();
        $data = [
            'first_name' => '杉林',
            'last_name' => '由樹',
            'gender' => 1,
            'email' => 'test2@example.com',
            'tel' => '09012345678a',
            'address' => '愛知県名古屋市',
            'building' => 'バステール303',
            'category_id' => $category->id,
            'detail' => '商品の配送状況について教えてください。発送はいつ頃になりますでしょうか。',
            'tag_ids' => [$tag1->id, $tag2->id],
        ];
        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：fails()で通過を確認する
        $this->assertTrue($validator->fails());
    }
}
