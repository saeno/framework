<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Facades;

/**
 * This is the facade calling the alias 'behat_mink'.
 */
class BehatMink extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'behat_mink';
    }
}
