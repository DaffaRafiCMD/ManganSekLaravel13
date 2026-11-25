<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,DashboardController,TempatController,MenuController,ReviewController,FavoritController,MealHackController,PromoController,ProfilController};
use App\Http\Middleware\RoleMiddleware;
Route::get('/', fn()=>redirect()->route(auth()->check()?'dashboard':'login'));
Route::view('/kredit-foto','credits')->name('credits');
Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login'])->middleware(['guest','throttle:10,1'])->name('login.submit');
Route::get('/register',[AuthController::class,'showRegister'])->name('register');
Route::post('/register',[AuthController::class,'register'])->middleware(['guest','throttle:10,1'])->name('register.submit');
Route::middleware('auth')->group(function () {
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/home',[TempatController::class,'home'])->name('home');
    Route::get('/kategori/{kategori}',[TempatController::class,'index'])->name('kategori');
    Route::get('/review/{tempat}',[ReviewController::class,'index'])->name('review.index');
    Route::get('/meal-hack',[MealHackController::class,'index'])->name('meal.index');
    Route::post('/meal-hack',[MealHackController::class,'store'])->name('meal.store');
    Route::get('/promo',[PromoController::class,'index'])->name('promo.index');
    Route::get('/profil',[ProfilController::class,'edit'])->name('profil.edit');
    Route::patch('/profil',[ProfilController::class,'update'])->name('profil.update');
    Route::middleware(RoleMiddleware::class.':admin')->group(function () {
        Route::resource('menu',MenuController::class)->except('show');
    });
    Route::middleware(RoleMiddleware::class.':user')->group(function () {
        Route::post('/review/{tempat}',[ReviewController::class,'store'])->name('review.store');
        Route::patch('/ulasan/{review}',[ReviewController::class,'update'])->name('review.update');
        Route::delete('/ulasan/{review}',[ReviewController::class,'destroy'])->name('review.destroy');
        Route::post('/favorit/{tempat}',[FavoritController::class,'toggle'])->name('favorit.toggle');
    });
});
