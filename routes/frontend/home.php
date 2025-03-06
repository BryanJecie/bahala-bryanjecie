<?php

use App\Http\Controllers\Frontend\HomeController;
use Tabuna\Breadcrumbs\Trail;

Route::get('/', [HomeController::class, 'index'])
    ->name('index')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('frontend.index'));
    });
