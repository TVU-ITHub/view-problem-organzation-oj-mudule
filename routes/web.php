<?php

use Illuminate\Support\Facades\Route;
use App\Models\Organization;
use App\Http\Controllers\OrganizationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    dd(Organization::all()->toArray());
});

Route::get('{organizationSlug}', [OrganizationController::class, 'show'])->name('organization.show');
