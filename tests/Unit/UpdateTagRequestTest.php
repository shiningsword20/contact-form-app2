<?php

namespace Tests\Unit;

use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateTagRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 自身の名前を維持したまま更新するとバリデーションを通過する(): void
    {
        // Arrange（準備）
        $tag = Tag::factory()->create(['name' => '質問']);

        $request = new UpdateTagRequest;
        $route = new Route('PUT', 'admin/tags/{tag}', []);
        $route->bind($request);
        $route->setParameter('tag', $tag->id);
        $request->setRouteResolver(fn () => $route);

        $rules = $request->rules();
        $data = ['name' => '質問'];

        // Act（実行）
        $validator = Validator::make($data, $rules);

        // Assert（検証）
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function 別のタグの名前に変更しようとして失敗する(): void
    {
        // Arrange（準備）
        $tag1 = Tag::factory()->create(['name' => '質問']);
        Tag::factory()->create(['name' => '要望']);

        $request = new UpdateTagRequest;
        $route = new Route('PUT', 'admin/tags/{tag}', []);
        $route->bind($request);
        $route->setParameter('tag', $tag1->id);
        $request->setRouteResolver(fn () => $route);

        $rules = $request->rules();
        $data = ['name' => '要望'];

        // Act（実行）
        $validator = Validator::make($data, $rules);

        // Assert（検証）
        $this->assertTrue($validator->fails());
    }
}
