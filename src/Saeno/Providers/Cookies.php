<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Phalcon\Http\Response\Cookies as BaseCookies;

/**
 * Get the 'cookies' service provider.
 */
class Cookies extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->instance('cookies', new BaseCookies, $singleton = true);
    }
}
