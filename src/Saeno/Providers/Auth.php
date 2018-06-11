<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

/**
 * This provider handles the general authentication.
 */
class Auth extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $auth_manager = config()->auth->manager;
        $this->app->instance('auth', new $auth_manager, $singleton = true);
    }
}
