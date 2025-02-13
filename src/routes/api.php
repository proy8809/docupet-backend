<?php

use Illuminate\Support\Facades\Route;
use App\Registration\Presentation\PetController;
use App\Registration\Presentation\PetTypeController;

Route::get("types/{typeKey}/breeds", [PetTypeController::class, "getBreeds"]);

Route::post("pets", [PetController::class, "store"]);