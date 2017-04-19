<?php

Route::get('/', [ 'uses' => 'PageController@index'] );

$router->group([
  'namespace' => 'Api'
], function () {
  resource('api', 'CommentController');
});


