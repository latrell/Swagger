<?php
Route::group([
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