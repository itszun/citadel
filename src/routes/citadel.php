<?php

use Illuminate\Support\Facades\Route;

Route::get('@/citadel/getView/{view}', function ($view) {
    return view($view)->render();
})->name('citadel.get_view');
