<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Support\Phalcon\Mvc;

use Phalcon\Mvc\Router as BaseRouter;

/**
 * {@inheritdoc}
 */
class Router extends BaseRouter
{
    /**
     * Contructor.
     *
     * @param bool $bool
     */
    public function __construct($bool)
    {
        parent::__construct($bool);
    }
}
