<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('fetch', function(Request $request) {
    return \App\Record::all()->random();
});

Route::post('/save_buffer',  function  (Request $request)  {
    $ip = $request->ip();
    $buffer = $request->buffer;

    $foundRecord = \App\Record::where("ip", "=", $ip)->first();
    if (!$foundRecord) {
        $foundRecord = new \App\Record();
        $foundRecord->ip = $ip;
        $foundRecord->save();
    }

    $foundRecord->buffer = json_encode($buffer);
    $foundRecord->save();

    return $foundRecord;
});
