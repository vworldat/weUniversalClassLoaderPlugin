weUniversalClassLoaderPlugin
====================

This plugin brings the Symfony2 PSR-0 UniversalClassLoader to your symfony 1 project. The namespaces can be configured in namespaces.yml config files.


Requirements
------------

- symfony 1.3 oder 1.4 (could work with previous versions too, untested)

Installation
------------

 * Install plugin in `/plugins/weUniversalClassLoaderPlugin` using GIT, SVN or whatever you like
 * Enable plugin in `/config/ProjectConfiguration.class.php`

``` php
<?php

class ProjectConfiguration extends sfProjectConfiguration
{
	public function setup()
	{
		...
		$this->enablePlugins('weUniversalClassLoaderPlugin');
		...
	}
}
```

Usage
-----

Let's assume you gut a plugin called /plugins/mySuperAwesomePlugin and want to use this namespaced PHP file:

``` php
<?php

namespace Acme\AwesomeClasses;

class SuperAwesome
{
}
```

* Add a file called `/plugins/mySuperAwesomePlugin/config/namespaces.yml`

``` yml
all:
  register:
    namespaces:
      # all src paths are relative to sf_root_dir
      'Acme\AwesomeClasses':  '/plugins/mySuperAwesomePlugin/src'
```

* Save your class to `/plugins/mySuperAwesomePlugin/src/Acme/AwesomeClasses/SuperAwesome.php`

That's it! The file won't be detected by the symfony 1 autoloader since it's outside the plugin's lib/ folder. If you now access `\Acme\AwesomeClasses\SuperAwesome` it will be loaded automatically.


Known limitations
-----------------

Because the namespaces config handler is initiated after `context.load_factories` has fired, you cannot use your namespaced classes beforehand. To be precise, you should wait for the `we.namespaces_classloader_available` event.

Events
------

Last but not least there are 2 events which will be fired by this plugin:

 * `config.namespaces_configuration_loaded` as soon as the namespaces.yml config files have been loaded
 * `we.namespaces_classloader_available` as soon as the ClassLoader is available
