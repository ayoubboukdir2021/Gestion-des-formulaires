<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/chart/chart-formulaires',[App\Http\Controllers\Api\ChartsController::class, 'chart_formulaires'])->name('chart.formulaire');
