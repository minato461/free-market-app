<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index');
Route::view('/register', 'register');
Route::view('/login', 'login');
Route::view('/item', 'item');
Route::view('/purchase', 'purchase');
Route::view('/address', 'address');
Route::view('/sell', 'sell');
Route::view('/mypage', 'mypage');
Route::view('/profile', 'profile');
