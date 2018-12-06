<?php
Route::group([
    'domain' => config('latrell-swagger.swagger_api_domain'),
	'middleware' => config('latrell-swagger.middleware'),
	'prefix' => config('latrell-swagger.prefix')
], function ()
{

	Route::get('/', [
		'as' => 'swagger_index',
		'uses' => 'Latrell\Swagger\SwaggerController@getIndex'
	]);

	Route::get('docs/{page?}', [
		'as' => 'swagger_docs',
		'uses' => 'Latrell\Swagger\SwaggerController@getDocs'
	]);
});