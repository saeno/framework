<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Saeno\Support\Phalcon\Mvc\Router as BaseRouter;

/**
 * This provider manages the url routes, which parses and provides a map
 * which the dispather could interpret and manages to call controller's action.
 */
class Router extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('router', function () {
            $router = new BaseRouter(false);

            $router->removeExtraSlashes(true);

            // $router->setUriSource(BaseRouter::URI_SOURCE_GET_URL); // default
            $router->setUriSource(BaseRouter::URI_SOURCE_SERVER_REQUEST_URI);

            return $router;
        });
    }
}
