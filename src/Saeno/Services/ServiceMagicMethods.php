<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Services;

use InvalidArgumentException;

trait ServiceMagicMethods
{
    public function __get($name)
    {
        if (di()->has($name) === false) {
            throw new InvalidArgumentException("Dependency Injection [$name] not found");
        }

        return di()->get($name);
    }
}
