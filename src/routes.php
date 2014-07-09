<?php
Route::group(array(
    'prefix' => Config::get('swagger::prefix')
), function ()
{

    Route::get('/', array(
        'as' => 'swagger_index',
        'uses' => 'Latrell\Swagger\SwaggerController@getIndex'
    ));

    Route::get('docs/{page?}', array(
        'as' => 'swagger_docs',
        'uses' => 'Latrell\Swagger\SwaggerController@getDocs'
    ));
});