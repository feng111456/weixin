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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info', function () {
    phpinfo();
});



Route::any('/indexa','wechat\Index@index');
Route::any('/indexs','wechat\Index@indexs');
//Route::any('/','wechat2\Index@index');

/**后台路由 ->middleware('CheckLogin')*/
// Route::prefix('admin')->group(function () {
//     Route::get('/index','admin\Admin@index');
//     Route::get('create','admin\Admin@create');
//     Route::post('store','admin\Admin@store');
//     Route::get('destroy/{id}','admin\Admin@destroy');
//     Route::get('edit/{id}','admin\Admin@edit');
//     Route::post('update/{id}','admin\Admin@update');
//     Route::post('paixu','admin\Admin@paixu');
// });
/**登录 */
Route::get('/admin/login','admin\Login@login');
Route::post('/admin/loginDo','admin\Login@loginDo');
/**后台首页 */
Route::prefix('admin')->group(function () {
    Route::get('/indexs','admin\Index@index');
    Route::get('/main','admin\Index@main');
    Route::get('create','admin\Index@create');
    Route::post('store','admin\Index@store');
    Route::get('weather','admin\Index@weather');
    Route::get('destroy/{id}','admin\Index@destroy');
    Route::get('edit/{id}','admin\Index@edit');
    Route::any('update/{id}','admin\Index@update');
});
/**前台路由 ->middleware('CheckLogin')*/
Route::prefix('index')->group(function () {
    Route::get('/index','index\Index@index');
    Route::get('/register','index\Index@register');
    Route::post('/getIdInfo','index\Index@getIdInfo');
    Route::post('/checkAccount','index\Index@checkAccount');
    Route::post('/registerDo','index\Index@registerDo');
});
//微信
Route::prefix('material')->group(function () {
    Route::get('index','admin\Material@index'); 
    Route::get('create','admin\Material@create');
    Route::post('store','admin\Material@store');
    Route::get('destroy/{id}','admin\Material@destroy');
    Route::get('edit/{id}','admin\Material@edit');
    Route::post('update/{id}','admin\Material@update');
    Route::any('addMenu','admin\Material@addMenu');
});
/**新闻 */
Route::prefix('news')->group(function () {
    Route::get('index','admin\News@index'); 
    Route::get('create','admin\News@create');
    Route::post('store','admin\News@store');
    Route::get('destroy/{id}','admin\News@destroy');
    Route::get('edit/{id}','admin\News@edit');
    Route::post('update/{id}','admin\News@update');
});
/**渠道 */
Route::prefix('channel')->group(function () {
    Route::get('index','admin\Channel@index'); 
    Route::get('icon','admin\Channel@icon'); 
    Route::get('create','admin\Channel@create');
    Route::post('store','admin\Channel@store');
    Route::get('destroy/{id}','admin\Channel@destroy');
    Route::get('edit/{id}','admin\Channel@edit');
    Route::post('update/{id}','admin\Channel@update');
});
