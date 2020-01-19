<?php

Route::get('/', function () {
    return view('welcome');
});

// Library - TDD

// Book
Route::post('/books', 'BooksController@store');
Route::patch('/books/{book}-{slug}', 'BooksController@update');
Route::delete('/books/{book}-{slug}', 'BooksController@destroy');
// Author
Route::post('/author', 'AuthorsController@store');