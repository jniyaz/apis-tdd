<?php

Route::get('/', function () {
    return view('welcome');
});

// Library Application - using TDD approach

// Book
Route::post('/books', 'BooksController@store');
Route::patch('/books/{book}-{slug}', 'BooksController@update');
Route::delete('/books/{book}-{slug}', 'BooksController@destroy');

// Author
Route::post('/author', 'AuthorsController@store');

// book checkout
Route::post('/checkout/{book}', 'BookCheckoutController@store');
Route::post('/checkin/{book}', 'BookCheckInController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
