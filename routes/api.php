<?php

use App\Models\DailyActivity;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('users', function (Request $request) {

    $queryBase = null;

    if ($request->has('search')) {

        $queryBase = DailyActivity::searchUser($request->get('search'));
    } else {
        $queryBase = DailyActivity::query();
    }
    return $queryBase->select('username')->groupBy('username')->get();
});