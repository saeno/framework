<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Phalcon\Mvc\Model\Transaction\Manager;

/**
 * Get the 'transactionManager' service provider.
 */
class TransactionManager extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->instance('transactionManager', new Manager, $singleton = true);
    }
}
