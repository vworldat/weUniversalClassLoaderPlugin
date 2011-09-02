<?php

class weUniversalClassLoaderLoader
{
	public function init(array $namespaces)
	{
		$root = sfConfig::get('sf_root_dir');
		
		require_once $root.$namespaces['Symfony\\Component\\ClassLoader'].'/Symfony/Component/ClassLoader/UniversalClassLoader.php';
		
		$loader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
		$loader->register();
		
		foreach ($namespaces as $namespace => $path)
		{
			$loader->registerNamespace($namespace, $root.$path);
		}
	}
}
