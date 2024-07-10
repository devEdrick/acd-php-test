<?php

use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    // Routes for Call Headers
    $r->addRoute('GET', '/', 'App\Controllers\CallController@index');
    $r->addRoute('GET', '/calls', 'App\Controllers\CallController@index');
    $r->addRoute('GET', '/calls/{id:\d+}', 'App\Controllers\CallController@show');
    $r->addRoute('GET', '/calls/create', 'App\Controllers\CallController@create');
    $r->addRoute('POST', '/calls/store', 'App\Controllers\CallController@store');
    $r->addRoute('GET', '/calls/{id:\d+}/edit', 'App\Controllers\CallController@edit');
    $r->addRoute('POST', '/calls/{id:\d+}/update', 'App\Controllers\CallController@update');
    $r->addRoute('POST', '/calls/{id:\d+}/delete', 'App\Controllers\CallController@delete');

    // Routes for Call Details
    $r->addRoute('GET', '/calls/{callId:\d+}/details/create', 'App\Controllers\CallDetailsController@create');
    $r->addRoute('POST', '/calls/{callId:\d+}/details/store', 'App\Controllers\CallDetailsController@store');
    $r->addRoute('GET', '/calls/{callId:\d+}/details/{id:\d+}/edit', 'App\Controllers\CallDetailsController@edit');
    $r->addRoute('POST', '/calls/{callId:\d+}/details/{id:\d+}/update', 'App\Controllers\CallDetailsController@update');
    $r->addRoute('POST', '/calls/{callId:\d+}/details/{id:\d+}/delete', 'App\Controllers\CallDetailsController@delete');
};
