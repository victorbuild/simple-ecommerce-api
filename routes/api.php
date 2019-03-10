<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::apiResource('product','ProductController');

Route::group(['prefix'=>'prodect'],function(){
  Route::apiResource('/{product}/review','ReviewController');
});
