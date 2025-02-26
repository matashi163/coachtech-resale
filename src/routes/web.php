<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ListController::class, 'viewList']);
Route::get('/item/{item_id}', [DetailController::class, 'viewDetail']);
Route::post('/search', [ListController::class, 'viewList']);
Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/set_profile', [ProfileController::class, 'viewSetProfile']);
    Route::post('/set_profile', [ProfileController::class, 'createProfile']);

    Route::group(['prefix' => '/mypage'], function () {
        Route::get('/', [ProfileController::class, 'viewMypage']);
        Route::get('/profile', [ProfileController::class, 'viewProfile']);
        Route::post('/profile', [ProfileController::class, 'updateProfile']);
    });

    Route::group(['prefix' => '/bookmark'], function() {
        Route::get('/create/{item_id}', [DetailController::class, 'createBookmark']);
        Route::get('/delete/{item_id}', [DetailController::class, 'deleteBookmark']);
    });

    Route::post('/comment', [DetailController::class, 'comment']);

    Route::group(['prefix' => '/purchase'], function() {
        Route::get('/{item_id}', [PurchaseController::class, 'viewPurchase']);
        Route::get('/address/{item_id}', [PurchaseController::class, 'viewChangeaddress']);
        Route::post('/change_address', [PurchaseController::class, 'changeAddress']);
        Route::get('/', [PurchaseController::class, 'purchase']);
    });

    Route::get('/sell', [SellController::class, 'viewSell']);
    Route::post('/sell', [SellController::class, 'sell']);
});
