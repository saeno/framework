<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Saeno\Facades\Facade;
use Saeno\Support\Phalcon\Mvc\Application as BaseApplication;

/**
 * This provider handles the @see \Phalcon\Mvc\Application
 * and also having an option to add a module.
 */
class Application extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('application', function () {
            $instance = new BaseApplication($this->getDI());

            Facade::setFacadeApplication($instance);

            return $instance;
        });
    }
}
