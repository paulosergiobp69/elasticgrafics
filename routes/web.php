<?php

use Illuminate\Support\Facades\Route;
use App\Articles\ArticlesRepository;
use App\Fipe_modelo\FipemodeloRepository;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', function (FipemodeloRepository $repository) {
    $elastics = env('ELASTICSEARCH_ENABLED');
    if($elastics){
//        dd($fipe_modelos);
        $fipe_modelos = $repository->search((string) request('q'));
        return view('Fipemodelos.elasticindex', [
            'fipe_modelos' => $fipe_modelos,
        ]);

    }else{
        $fipe_modelos = $repository->search((string) request('q'));
        return view('Fipemodelos.index', [
            'fipe_modelos' => $fipe_modelos,
        ]);
    }

});


Route::get('/artigos', function () {
    return view('articles.index', [
        'articles' => App\Article::all(),
    ]);
});

Route::get('/search', function (ArticlesRepository $repository) {
    $articles = $repository->search((string) request('q'));
    return view('articles.index', [
        'articles' => $articles,
    ]);
});


Route::get('/search_fipe', function (FipemodeloRepository $repository) {
    
    $fipe_modelos = $repository->search((string) request('q'));

     return view('Fipemodelos.index', [
        'fipe_modelos' => $fipe_modelos,
    ]);

});

Route::get('ajax', function(){ return view('ajax'); });
Route::post('/postajax','AjaxController@post');

Route::get('/search_fipe_grafico', function (FipemodeloRepository $repository) {
//dd('paulo aqui')    ;
    $fipe_modelos = $repository->search_modelo_grafico((string) request('q'));
    //$fipe_modelos = $repository->search_modelo_grafico(string $modelo_cod_fipe, String $ano_modelo);

    return $fipe_modelos;
});

Route::get('/search_widget', function (FipemodeloRepository $repository) {
    
  
    $fipe_modelos = $repository->search((string) request('q'));

    $elastics = env('ELASTICSEARCH_ENABLED');
    if($elastics){
        return view('Fipemodelos.elasticwidget', [
            'fipe_modelos' => $fipe_modelos,
        ]);
        
    }else{
     return view('Fipemodelos.widget', [
        'fipe_modelos' => $fipe_modelos,
    ]);
     }

});
