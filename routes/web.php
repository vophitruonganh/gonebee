<?php

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

Route::get('/g', function() {
    //in a loop I add 3 jobs to gearman with different content. The purpose is to see 3 different emails with 3 different contents
    foreach (array(1) as $row) {
        Queue::push('TaskProcess\Services\SendMail', array('message' => 'Message №' . $row));
    }
});
