<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Saeno\Support\Redirect\Redirect as BaseRedirect;

/**
 * This provider manages the redirection of a page or dispatched request.
 */
class Redirect extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->instance('redirect', new BaseRedirect, $singleton = true);
    }
}
