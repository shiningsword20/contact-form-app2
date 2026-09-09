<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

// お問い合わせフォーム入力ページ表示
Route::get('/', [ContactController::class, 'index']);
// お問い合わせフォーム確認ページ表示
Route::post('/contacts/confirm', [ContactController::class, 'confirm']);
// お問い合わせフォーム入力内容の登録
Route::post('/contacts', [ContactController::class, 'store']);
// サンクスページの表示
Route::get('/thanks', [ContactController::class, 'thanks']);

// 管理者画面一覧表示
Route::get('/admin', [AdminController::class, 'index']);
// 管理者画面詳細ページ表示
Route::get('/admin/contacts/{contact}', [AdminController::class, 'show']);
// タグの追加
Route::post('/admin/tags', [TagController::class, 'store']);
// タグ編集画面表示
Route::get('/admin/tags/{tag}/edit', [TagController::class, 'edit']);
// タグの更新
Route::put('/admin/tags/{tag}', [TagController::class, 'update']);
// タグの更新
Route::delete('/admin/tags/{tag}', [TagController::class, 'destroy']);
