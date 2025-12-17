<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\LikeCommentController;


Route::get('/', [ItemController::class, 'index'])->name('item.index');

Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('status', 'ログアウトしました。');
})->middleware('auth')->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/item/{item}/toggle', [LikeCommentController::class, 'toggle'])
        ->name('like.toggle');

    Route::post('/item/{item}/comment', [LikeCommentController::class, 'store'])
        ->name('comment.store');

    Route::get('/items/likes', [ItemController::class, 'mylist'])->name('item.mylist');

    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'process'])->name('purchase.process');

    Route::get('/mypage/address', [ShippingAddressController::class, 'edit'])->name('address.edit');
    Route::patch('/mypage/address', [ShippingAddressController::class, 'update'])->name('address.update');

    Route::get('/mypage', [UserController::class, 'showMypage'])->name('mypage.index');
    //Route::get('/mypage/bought', [UserController::class, 'showMypage'])->name('user.bought');
    //Route::get('/mypage/selling', [UserController::class, 'showMypage'])->name('user.selling');

    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [UserController::class, 'update'])->name('profile.update');
});