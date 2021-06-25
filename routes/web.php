<?php

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


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('user', 'UserController');
    Route::resource('permission', 'PermissionController');
    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::post('/profile', 'UserController@postProfile')->name('user.postProfile');
    Route::get('/password/change', 'UserController@getPassword')->name('userGetPassword');
    Route::post('/password/change', 'UserController@postPassword')->name('userPostPassword');
});


Route::get('/alumni', 'AlumniController@index')->name('alumni.index');
Route::get('/alumni/search', 'AlumniController@search');
Route::get('/alumni-kamar/search', 'AlumniController@searchKamar');
Route::get('/alumni-tahun/search', 'AlumniController@searchTahun');
Route::group(['middleware' => ['auth', 'permission:create user']], function () {
    Route::post("/alumni", "AlumniController@store");
    Route::put("/alumni/{id}", "AlumniController@update");
    Route::delete("/alumni/{id}", "AlumniController@delete");
});

Route::group(['middleware' => ['auth', 'permission:membuat berita']], function () {
    Route::get('/berita', 'BeritaController@index')->name('berita.index');
    Route::post("/berita", "BeritaController@store");
    Route::get("/getAllBerita", "BeritaController@getAll");
    Route::put("/berita/{id}", "BeritaController@update");
    Route::delete("/berita/{id}", "BeritaController@delete");
    Route::get("/berita/edit/{id}", "BeritaController@edit");
    Route::post("/berita/show/{id}", "BeritaController@update2")->name("show.beriita");
    // Route::get('/berita/search', 'BeritaController@search');
});

Route::group(['middleware' => ['auth', 'permission:membuat artikel']], function () {
    Route::get('/artikel', 'ArtikelController@index')->name('artikel.index');
    Route::post('/artikel', 'ArtikelController@store');
    Route::get("/getAllArtikel", "ArtikelController@getAll");
    Route::delete("/artikel/{id}", "ArtikelController@delete");
    Route::put("/artikel/{id}", "ArtikelController@update");
});


Route::group(['middleware' => ['auth', 'permission:create role']], function () {
    Route::resource('role', 'RoleController');
});


Route::post("/pendaftaran-santri", "PendaftaranSantriController@store")->name("pendaftaran-santri.store");
Route::group(['middleware' => ['auth', 'permission:melihat pendaftar']], function () {
    Route::get("/pendaftaran-santri", "PendaftaranSantriController@index")->name("pendaftaran.santri");
    Route::get("/getAllPendaftar", "PendaftaranSantriController@getAll");
    Route::delete("/pendaftar/{id}", "PendaftaranSantriController@delete");
});

Route::group(['middleware' => ['auth', 'permission:membuat biografi']], function () {
    Route::get("pendaftaran-santri", "PendaftaranSantriController@index")->name("pendaftaran.santri");
});


Route::get('/biografi', 'BiografiController@index')->name("biografi");
Route::get("/getAllBiografi", "BiografiController@getAll");
Route::group(['middleware' => ['auth', 'permission:membuat biografi']], function () {
    Route::post('/biografi', 'BiografiController@store');
    Route::delete("/biografi/{id}", "BiografiController@delete");
    Route::put("/biografi/{id}", "BiografiController@update");
});






Auth::routes();


//////////////////////////////// axios request

Route::get('/getAllPermission', 'PermissionController@getAllPermissions');
Route::post("/postRole", "RoleController@store");

Route::get("/getAllUsers", "UserController@getAll");

Route::get("/getAllRoles", "RoleController@getAll");
Route::get("/getAllPermissions", "PermissionController@getAll");

/////////////axios create user
Route::post('/account/create', 'UserController@store');
Route::put('/account/update/{id}', 'UserController@update');
Route::delete('/delete/user/{id}', 'UserController@delete');
Route::get('/search/user', 'UserController@search');
Route::get('/search-kamar/user', 'UserController@searchKamar');


Route::get("/getAllAlumni", "AlumniController@getAll");
