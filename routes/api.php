<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

Route::get('/cities/{state_id}', [CityController::class, 'getCities']);
