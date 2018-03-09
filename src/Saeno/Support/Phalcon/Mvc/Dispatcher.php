<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Support\Phalcon\Mvc;

use Phalcon\Mvc\Dispatcher as BaseDispatcher;

/**
 * {@inheritdoc}
 */
class Dispatcher extends BaseDispatcher
{
    /**
     * Get controller suffix.
     *
     * @return string
     */
    public function getControllerSuffix()
    {
        return $this->_handlerSuffix;
    }
}
