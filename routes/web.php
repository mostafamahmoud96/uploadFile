<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth'], function () {
    Route::post('upload/media', [FileController::class, 'storeMedia'])->name('upload_file');
    Route::get('/uploadFile', [FileController::class, 'create'])->name('fileupload_view');
    Route::get('/myuploads', [FileController::class, 'index'])->name('list_files');
    Route::get('download/{fileId}', [FileController::class, 'download'])->name('file_download');
});