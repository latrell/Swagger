<?php
namespace Latrell\Swagger;

class Swagger
{

	protected $options;

	public function __construct($options = [])
	{
		$this->options = $options;
	}

	public function fire()
	{
		$projectPaths = $this->realpaths($this->paths);
		$excludePaths = $this->realpaths($this->exclude);
		$outputPath = head((array) $this->output) . DIRECTORY_SEPARATOR;

		$swagger = new \Swagger\Swagger($projectPaths, $excludePaths);

		$resourceList = $swagger->getResourceList([
			'output' => 'array',
			'suffix' => $this->suffix,
			'apiVersion' => $this->default_api_version,
			'swaggerVersion' => $this->default_swagger_version,
			'template' => $this->api_doc_template
		]);
		$resourceOptions = [
			'output' => 'json',
			'defaultSwaggerVersion' => $resourceList['swaggerVersion'],
			'defaultBasePath' => $this->default_base_path
		];
		if (isset($resourceList['apiVersion'])) {
			$resourceOptions['defaultApiVersion'] = $resourceList['apiVersion'];
		}

		$resourceName = false;
		$output = [];
		foreach ($swagger->getResourceNames() as $resourceName) {
			$json = $swagger->getResource($resourceName, $resourceOptions);
			$resourceName = str_replace(DIRECTORY_SEPARATOR, '-', ltrim($resourceName, DIRECTORY_SEPARATOR));
			$output[$resourceName] = $json;
		}
		if (! $output) {
			throw new SwaggerException('no valid resources found');
		}
		if (file_exists($outputPath) && ! is_dir($outputPath)) {
			throw new SwaggerException(sprintf('[%s] is not a directory', $outputPath));
		} elseif (! file_exists($outputPath) && ! mkdir($outputPath, 0755, true)) {
			throw new SwaggerException(sprintf('[%s] is not writeable', $outputPath));
		}
		if (! file_exists($outputPath . '/.gitignore')) {
			file_put_contents($outputPath . '/.gitignore', "*\n!.gitignore");
		}

		$filename = $outputPath . 'api-docs.json';
		if (file_put_contents($filename, \Swagger\Swagger::jsonEncode($resourceList, true))) {
			$this->logger('Created ' . $filename);
		}
		foreach ($output as $name => $json) {
			$name = str_replace(DIRECTORY_SEPARATOR, '-', ltrim($name, DIRECTORY_SEPARATOR));
			$filename = $outputPath . $name . '.json';
			$this->logger('Created ' . $filename);
			file_put_contents($filename, $json);
		}
		$this->logger('');
	}

	protected function logger()
	{
		// echo join('', func_get_args()), PHP_EOL;
	}

	/**
	 * 检查并转换路径为绝对路径。
	 *
	 * @param array $paths
	 * @throws SwaggerException
	 * @return array
	 */
	protected function realpaths($paths)
	{
		if (is_string($paths)) {
			$paths = [
				$paths
			];
		}
		if (! is_array($paths)) {
			return [];
		}
		foreach ($paths as $i => $path) {
			$paths[$i] = realpath($path);
			if ($paths[$i] === false) {
				$paths[$i] = realpath(base_path($path));
				if ($paths[$i] === false) {
					throw new SwaggerException("Path \"{$path}\" not found");
				}
			}
		}
		return $paths;
	}

	public function __set($key, $value)
	{
		$this->options[$key] = $value;
	}

	public function __get($key)
	{
		return $this->options[$key];
	}

	public function __isset($key)
	{
		return isset($this->options[$key]);
	}
}