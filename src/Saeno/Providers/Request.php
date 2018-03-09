<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Saeno\Support\Phalcon\Http\Request as BaseRequest;

/**
 * This provider manages the dispatcher requests.
 */
class Request extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->instance('request', new BaseRequest, $singleton = true);
    }
}
