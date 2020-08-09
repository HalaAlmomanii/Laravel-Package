<?php

Route::view('blog','press::test');

Route::get('/blogs','BlogController@index')->name('blog.index');