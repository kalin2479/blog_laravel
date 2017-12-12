<?php

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

Route::get('/', 'PagesController@home');
Route::get('blog/{post}', 'PostsController@show')->name('posts.show');

/*
* Vamos a crear un grupo  llamado admin que quiere decir que todas
las rutas van a estar precedidas por admin
Para ya no colocar Admin colocaremos la sgte instruccion: namespace => Admin
De esta manera tambien podemos indicar que todos los que se encuentran en este grupo
estaran bajo el control del middleware auth
*/
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'auth'],
function () {
  // colocamos el / para que nos lleve a la raiz del grupo y no
  // tener admin/admin
  Route::get('/', 'AdminController@index')->name('dashboard');
  Route::get('posts','PostsController@index')->name('admin.posts.index');
  Route::get('posts/create','PostsController@create')->name('admin.posts.create');
  Route::post('posts','PostsController@store')->name('admin.posts.store');
  Route::get('posts/{post}','PostsController@edit')->name('admin.posts.edit');
  Route::put('posts/{post}','PostsController@update')->name('admin.posts.update');
  Route::post('posts/{post}/photos','PhotosController@store')->name('admin.posts.photos.store');

});
/*
* fin
*/
Route::get('posts', function () {
    return App\Post::all();
});



// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
