<?php
return array(
	'enable' => env('SWAGGER_ENABLE', null),

	'middleware' => 'web',
	'prefix' => 'api-docs',

	'paths' => [
		app_path(),
		base_path('routes')
	],
	'exclude' => null,

	'title' => 'Swagger UI',

    'swagger_api_domain' => '',

    'constants' => [
        // 'API_HOST' => env('SWAGGER_API_HOST')
    ]
);