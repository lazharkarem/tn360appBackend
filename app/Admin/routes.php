<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->resource('users', UserController::class);
    $router->resource('clients', ClientController::class);
    $router->resource('articles', ArticlesController::class);
    $router->resource('article-types', ArticleTypeController::class);
    $router->resource('marques', MarqueController::class);
    $router->resource('deal-depense', DealDepenseController::class);
    $router->resource('deal-frequence', DealFrequenceController::class);
    $router->resource('deal-marque', DealMarqueController::class);
    $router->resource('deal-anniversaire', DealAnniversaireController::class);
    $router->resource('deal-offre', DealOffreController::class);
    $router->resource('banners', BannerController::class);

    $router->get('/', 'HomeController@index')->name('home');


});
