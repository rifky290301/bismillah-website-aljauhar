<?php

use App\Models\Berita;
use App\Models\Biografi;
use App\Models\Testimoni;
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

// Route::get('/', 'HomeController@welcome');
Route::get('/', function () {
    $allBerita = Berita::where('publish', true)->latest()->get();
    $allTestimoni = Testimoni::where('publish', true)->latest()->get();
    $allBiografi = Biografi::where('publish', true)->latest()->get();
    return view('index', compact("allBerita", "allTestimoni", "allBiografi"));
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
    Route::post("/photo-alumni/{id}", "AlumniController@upload");

    // !delete santri
    Route::delete("/santri/{id}", "SantriController@delete");
});

// !SANTRI AKTIF SEKARANG
Route::post("/photo-santri/{id}", "SantriController@upload");
Route::get('/santri', 'SantriController@index')->name('santri.index');
Route::post('/santri', 'SantriController@store');
Route::get('/getAllsantri', 'SantriController@getAll');
Route::put("/santri/{id}", "SantriController@update");


Route::group(['middleware' => ['auth', 'permission:membuat berita']], function () {
    Route::get('/berita', 'BeritaController@index')->name('berita.index');
    Route::post("/berita", "BeritaController@store");
    Route::get("/getAllBerita", "BeritaController@getAll");
    Route::put("/berita/{id}", "BeritaController@update");
    Route::delete("/berita/{id}", "BeritaController@delete");
    Route::get("/berita/edit/{id}", "BeritaController@edit");
    Route::post("/photo-berita/{id}", "BeritaController@upload");
    // Route::post("/berita/show/{id}", "BeritaController@update2")->name("show.beriita");
    // Route::get('/berita/search', 'BeritaController@search');
});

Route::group(['middleware' => ['auth', 'permission:membuat artikel']], function () {
    Route::get('/artikel', 'ArtikelController@index')->name('artikel.index');
    Route::post('/artikel', 'ArtikelController@store');
    Route::get("/getAllArtikel", "ArtikelController@getAll");
    Route::delete("/artikel/{id}", "ArtikelController@delete");
    Route::put("/artikel/{id}", "ArtikelController@update");
    Route::post("/gambar-artikel/{id}", "ArtikelController@upload");
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

// Route::group(['middleware' => ['auth', 'permission:membuat biografi']], function () {
//     Route::get("pendaftaran-santri", "PendaftaranSantriController@index")->name("pendaftaran.santri");
// });


Route::get("/getAllBiografi", "BiografiController@getAll");
Route::group(['middleware' => ['auth', 'permission:membuat biografi']], function () {
    Route::get('/biografi', 'BiografiController@index')->name("biografi");
    Route::post('/biografi', 'BiografiController@store');
    Route::delete("/biografi/{id}", "BiografiController@delete");
    Route::put("/biografi/{id}", "BiografiController@update");
    Route::post("/photo-biografi/{id}", "BiografiController@upload");

    //! TESTIMONI
    Route::get("/getAllTestimoni", "TestimoniController@getAll");
    Route::get('/testimoni', 'TestimoniController@index')->name("testimoni.index");
    Route::post('/testimoni', 'TestimoniController@store');
    Route::delete("/testimoni/{id}", "TestimoniController@delete");
    Route::put("/testimoni/{id}", "TestimoniController@update");
    Route::post("/photo-testimoni/{id}", "TestimoniController@upload");
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




// !FRONTEND
Route::get('/artikel-santri', 'ArtikelController@client')->name('artikel.santri');
