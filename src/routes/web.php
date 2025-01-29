<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\PurchaseController;

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
Route::post('/search', [ListController::class, 'search']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/set_profile', function() {
        return view('set_profile');
    });
    Route::group(['prefix' => '/bookmark'], function() {
        Route::get('/create/{item_id}', [DetailController::class, 'createBookmark']);
        Route::get('/delete/{item_id}', [DetailController::class, 'deleteBookmark']);
    });
    Route::post('/comment', [DetailController::class, 'comment']);
    Route::group(['prefix' => '/purchase'], function() {
        Route::get('/{item_id}', [PurchaseController::class, 'viewPurchase']);
    });
});
