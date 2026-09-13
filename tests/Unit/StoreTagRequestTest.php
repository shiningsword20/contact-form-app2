<?php

namespace Tests\Unit;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreTagRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 正しいタグ名でバリデーションを通過する(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        $rules = (new StoreTagRequest)->rules();
        $data = ['name' => '金銭'];

        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：passes()で通過を確認する
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function タグ名が空だとバリデーションが失敗する(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        $rules = (new StoreTagRequest)->rules();
        $data = ['name' => ''];

        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：fails()で失敗を確認する
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function タグ名が文字数制限を超え居ているとバリデーションが失敗する(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        $rules = (new StoreTagRequest)->rules();
        $data = [
            'name' => str_repeat('a', 51),
        ];

        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：fails()で失敗を確認する
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function タグ名が重複しているとバリデーションが失敗する(): void
    {
        // Arrange（準備）：テスト用のデータとルールを用意する
        Tag::factory()->create(['name' => '金銭']);
        $rules = (new StoreTagRequest)->rules();
        $data = ['name' => '金銭'];

        // Act（実行）：Validatorを作成する
        $validator = Validator::make($data, $rules);

        // Assert（検証）：fails()で失敗を確認する
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('name'));
    }
}
