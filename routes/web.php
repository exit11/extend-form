<?php

use Illuminate\Routing\Router;

/* Front */
Route::group([
    'namespace'     => 'Exit11\ExtendForm\Http\Controllers',
    'middleware'    => ['web'],
], function (Router $router) {
    
    $router->get('editor/fetchURL', 'EditorController@fetchURL');
    $router->post('editor/uploadImage', 'EditorController@uploadImage');
    $router->post('editor/fetchImageUrl', 'EditorController@fetchImageUrl');
    $router->get('editor/drawEditorBlocks', 'EditorController@drawEditorBlocks');
    
});