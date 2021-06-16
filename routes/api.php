<?php

use App\Http\Controllers\WeatherApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/city-weather', [WeatherApiController::class, 'searchWeatherForOneCity']);
Route::get('/city-weather-forecast', [WeatherApiController::class, 'weatherCityWithForecast']);
Route::get('/city-weather-list', [WeatherApiController::class, 'searchHandleListResults']);
Route::get('/city-weather-detailed', [WeatherApiController::class, 'searchWeatherOneCityDetailed']);
