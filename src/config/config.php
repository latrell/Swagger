<?php
return array(
	'enable' => env('SWAGGER_ENABLE', null),

	'prefix' => 'api-docs',

	'paths' => [
		app_path(),
		base_path('routes')
	],
	'output' => storage_path('swagger/docs'),
	'exclude' => null,
	'default-base-path' => null,
	'default-api-version' => null,
	'default-swagger-version' => null,
	'api-doc-template' => null,
	'suffix' => '.{format}',

	'title' => 'Swagger UI'
);