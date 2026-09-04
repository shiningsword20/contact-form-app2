<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// お問い合わせフォーム入力ページ表示
Route::get('/', [ContactController::class, 'index']);
// お問い合わせフォーム確認ページ表示
Route::post('/contacts/confirm', [ContactController::class, 'confirm']);
// お問い合わせフォーム入力内容の登録
Route::post('/contacts', [ContactController::class, 'store']);
// サンクスページの表示
Route::get('/thanks', [ContactController::class, 'thanks']);
