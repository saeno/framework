<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Saeno\Support\Phalcon\Mvc\URL as BaseURL;

/**
 * This provider instantiates the @see \Saeno\Support\Phalcon\Mvc\URL.
 */
class URL extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Get all this service provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return ['url'];
    }

    /**
     * {@inheridoc}.
     */
    public function boot()
    {
        $url = resolve('url');
        $url->setDI($this->getDI());
        $url->setBaseUri($url->getFullUrl().'/');
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('url', function () {
            return new BaseURL();
        });
    }
}
