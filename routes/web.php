<?php

use Illuminate\Routing\Router;

/* Front */
Route::group([
    'namespace'     => 'Exit11\ExtendForm\Http\Controllers',
    'middleware'    => ['web'],
], function (Router $router) {
    
    $router->get('editor/fetchURL', 'EditorController@fetchURL');
    
});