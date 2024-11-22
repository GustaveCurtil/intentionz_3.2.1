<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\OrganisationController;


Route::get('/', [PageController::class, 'thuis'])->middleware('detectDevice')->name('thuis');
Route::get('/⌂', [PageController::class, 'overzichtGebruiker'])->middleware('detectDevice')->name('overzicht-gebruiker');
Route::get('/⌨', [PageController::class, 'overzichtOrganisatie'])->middleware('detectDevice')->name('overzicht-organisatie');
Route::get('/aanmaken', [PageController::class, 'aanmaken'])->middleware('auth')->name('aanmaken');
// Route::get('/aanmaken-organisatie', [PageController::class, 'aanmakenOrganisatie'])->middleware('auth')->name('aanmaken-organisatie');
Route::get('/instellingen', [PageController::class, 'instellingen'])->middleware('detectDevice')->name('instellingen');
Route::get('/over', [PageController::class, 'over'])->middleware('detectDevice')->name('over');
Route::get('/zen', [PageController::class, 'zen'])->middleware('detectDevice')->name('zen');

Route::get('/aanmelden', [PageController::class, 'aanmelden'])->middleware('detectDevice')->name('aanmelden');
Route::get('/registreren', [PageController::class, 'registreren'])->middleware('detectDevice')->name('registreren');

Route::get('/{id}-{titel}', [PageController::class, 'publiekEvenement'])->where(['id' => '[0-9]+', 'titel' => '[-a-zA-Z0-9]+'])->middleware('detectDevice');
Route::get('/uitnodiging', [PageController::class, 'priveEvenement'])->middleware('detectDevice');

/* ACCOUNT CRUD */
Route::post('/maak-gebruiker', [GuestController::class, 'createUser']);
Route::post('/maak-organisatie', [OrganisationController::class, 'createOrganisation']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::delete('/verwijder', [UserController::class, 'delete']);

/* INSTELLINGEN */
Route::post('/kleuren', [PlayController::class, 'kleuren']);
Route::get('/kleuren-resetten', [PlayController::class, 'kleurenResetten']);
Route::post('/devicelink', [GuestController::class, 'devicelink']);
Route::post('/wijzignaam', [UserController::class, 'wijzignaam']);
Route::post('/wijzigwachtwoord', [UserController::class, 'wijzigwachtwoord']);
Route::post('/wijzigemail', [UserController::class, 'wijzigemail']);

/* STANDAARD GEGEVENS ORGANISATIE */
Route::post('/wijzig-adres', [OrganisationController::class, 'wijzigAdres']);

/* EVENEMENT CRUD */
Route::post('/maak-evenenement-openbaar', [PublicEventController::class, 'createEvent']);