<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FriendController;

Route::get('/',[UserController::class, 'showRegister']);

Route::get('/register', [UserController::class, 'showRegister'])->name('user.register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLogin'])->name('user.login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['user.auth'])->group(function () {
    Route::get('/user/home', [UserController::class, 'home'])->name('user.home');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/logout', [UserController::class, 'logout'])->name('user.logout');

    Route::get('/user/friends', [FriendController::class, 'index'])->name('user.friends');
    Route::post('/user/friends/send/{id}', [FriendController::class, 'sendRequest'])->name('friends.send');
    // Route::post('/user/friends/respond/{id}/{status}', [FriendController::class, 'respondToSameCity'])->name('friends.respond');
    Route::post('/user/friends/accept/{id}', [FriendController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/user/friends/ignore/{id}', [FriendController::class, 'ignoreRequest'])->name('friends.ignore');
});

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{id}/block', [AdminController::class, 'blockUser'])->name('admin.block');
    Route::post('/admin/users/{id}/unblock', [AdminController::class, 'unblockUser'])->name('admin.unblock');
});
