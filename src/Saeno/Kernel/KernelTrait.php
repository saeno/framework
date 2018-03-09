<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Kernel;

use Phalcon\Config;
use Saeno\Support\Phalcon\Di;
use Saeno\Services\Container;

/**
 * The Kernel Trait.
 *
 * @see \Saeno\Kernel\Kernel
 * @property \Phalcon\DiInterface $di
 */
trait KernelTrait
{
    /**
     * Instantiate a factory dependency injection.
     *
     * @return \Saeno\Kernel\Kernel
     */
    public function loadFactory()
    {
        $this->di = new Di;

        # pre-add the bench marking tool
        $this->di->setShared('benchmark', function () {
            return new \Saeno\Util\Benchmark\Benchmark(SAENO_START);
        });

        if (is_cli()) {
            resolve('benchmark')->here('Instantiating Phalcon Di');
        }

        return $this;
    }

    /**
     * Load the configurations.
     *
     * @return \Saeno\Kernel\Kernel
     */
    public function loadConfig()
    {
        # let's create an empty config with just an empty
        # array, this is just for us to prepare the config
        $this->di->setShared('config', function () {
            return new Config([]);
        });

        # get the paths and merge the array values to the
        # empty config as we instantiated above
        config(['path' => $this->paths]);

        # now merge the assigned environment
        config(['environment' => $this->getEnvironment()]);

        # iterate all the base config files and require
        # the files to return an array values
        $base_config_files = iterate_require(
            folder_files($this->paths['config'])
        );

        # iterate all the environment config files and
        # process the same thing as the base config files
        $env_config_files = iterate_require(
            folder_files(
                url_trimmer(
                    $this->paths['config'].'/'.$this->getEnvironment()
                )
            )
        );

        # merge the base config files and the environment
        # config files as one in the our DI 'config'
        config($base_config_files);
        config($env_config_files);

        if (is_cli()) {
            resolve('benchmark')->here('Loading Configurations');
        }

        return $this;
    }

    /**
     * Load the project timezone.
     *
     * @return \Saeno\Kernel\Kernel
     */
    public function loadTimeZone()
    {
        date_default_timezone_set(config()->app->timezone);

        if (is_cli()) {
            resolve('benchmark')->here('Setting Time Zone');
        }

        return $this;
    }

    /**
     * Provide the most prioritized service providers to be loaded internally, before
     * user's manual providers.
     *
     * @return array
     */
    protected function prioritizedProviders()
    {
        return [];
    }

    /**
     * Load the providers.
     *
     * @param  bool $after_module If you want to load services after calling
     *                               run() function
     * @return \Saeno\Kernel\Kernel
     */
    public function loadServices($after_module = false, $services = [])
    {
        # load all the service providers, providing our
        # native phalcon classes
        $container = new Container;
        $container->setDI($this->di);

        if (empty($services)) {
            $services = config('app.services')->toArray();
        }

        $services = array_merge($this->prioritizedProviders(), $services);

        foreach ($services as $service) {
            $instance = new $service;
            $instance->setDI($this->di);

            if ($instance->isAfterModule() === $after_module) {
                $container->addServiceProvider($instance);
            }
        }

        $container->handle();

        if (is_cli()) {
            resolve('benchmark')->here('   Loaded All Service Providers');
        }

        return $this;
    }
}
