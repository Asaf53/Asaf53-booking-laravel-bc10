<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyRoomContoller;
use App\Http\Controllers\PropertyRoomImagesController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('city/{id}', [HomeController::class, 'city']);

Route::post('/partner', [PartnerController::class, 'partner'])->name('partner')->middleware('role:client');

Route::resource('properties', PropertyController::class)->middleware('role:admin|partner');
Route::resource('users', UserController::class)->middleware('role:superadmin|admin');
Route::resource('property-types', PropertyTypeController::class)->middleware('role:admin');
Route::resource('property-rooms', PropertyRoomContoller::class)->middleware('role:admin|partner|client');
Route::resource('reservations', ReservationController::class)->middleware('role:admin|partner|client');


