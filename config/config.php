<?php

$this->dispatcher->connect('context.load_factories', function(sfEvent $event)
	{
		$config = sfProjectConfiguration::getActive();
		if ($config instanceof sfApplicationConfiguration)
		{
			$configCache = $config->getConfigCache();
			include($configCache->checkConfig('config/namespaces.yml'));
		}
	}
);

$this->dispatcher->connect('config.namespaces_configuration_loaded', function(sfEvent $event)
	{
		$loader = new weUniversalClassLoaderLoader();
		$loader->init(sfConfig::get('namespaces_register_namespaces'));
		
		$event->getSubject()->notify(new sfEvent($loader, 'we.namespaces_classloader_available'));
	}
);
