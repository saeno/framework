<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Kernel;

/**
 * Acts like a manager that initializes all the configurations/environments and module.
 */
class Kernel
{
    use KernelTrait;

    /**
     * The dependency injection.
     *
     * @var \Phalcon\DiInterface
     */
    private $di;

    /**
     * The configured environment.
     *
     * @var string
     */
    private $env;

    /**
     * The path provided.
     *
     * @var mixed
     */
    private $paths;

    /**
     * Set the paths.
     *
     * @param mixed $paths
     * @return \Saeno\Kernel\Kernel
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;

        if (is_cli()) {
            resolve('benchmark')->here('Setting Paths');
        }

        return $this;
    }

    /**
     * Set the environment.
     *
     * @param string $env
     * @return \Saeno\Kernel\Kernel
     */
    public function setEnvironment($env)
    {
        $this->env = $env;

        if (is_cli()) {
            resolve('benchmark')->here('Setting Environment');
        }

        return $this;
    }

    /**
     * Get the environment.
     *
     * @return string Current environment
     */
    public function getEnvironment()
    {
        return $this->env;
    }

    /**
     * Register modules.
     *
     * @return mixed
     */
    public function modules()
    {
        config(['modules' => $this->di->get('module')->all()]);

        $application = $this->di->get('application');
        $application->registerModules(config()->modules->toArray());

        foreach ($application->getModules() as $key => $module) {
            require_once realpath($this->paths['app']) . "/Modules/$key/Routes.php";
        }

        if (is_cli()) {
            resolve('benchmark')->here('Registering All Modules');
        }

        return $this;
    }

    /**
     * Handle request and display output
     *
     * @return mixed
     */
    public function run()
    {
        echo $this->di->get('application')->handle()->getContent();
    }
}
