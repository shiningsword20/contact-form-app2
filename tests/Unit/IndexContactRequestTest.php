<?php

namespace Tests\Unit;

use App\Http\Requests\IndexContactRequest;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class IndexContactRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正しい検索条件でバリデーションを通過する(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        $category = Category::factory()->create();
        $rules = (new IndexContactRequest)->rules();
        $data = [
            'keyword' => '田中',
            'gender' => 1,
            'category_id' => $category->id,
            'date' => '2026-09-11',
        ];

        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：passes()で通過を確認する
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function 不正な性別値は拒否する(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        $category = Category::factory()->create();
        $rules = (new IndexContactRequest)->rules();
        $data = [
            'keyword' => '田中',
            'gender' => 4,
            'category_id' => $category->id,
            'date' => '2026-09-12',
        ];

        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：fails()で失敗を確認する
        $this->assertTrue($validator->fails());
    }
}
