<?php

Route::get('/', function () {
    return view('welcome');
});

// Library - TDD
Route::post('/books', 'BooksController@store');
Route::patch('/books/{book}', 'BooksController@update');