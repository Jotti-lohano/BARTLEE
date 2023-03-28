<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;




Route::get('/{name?}',AdminController::class)->where('name','.*');

?>