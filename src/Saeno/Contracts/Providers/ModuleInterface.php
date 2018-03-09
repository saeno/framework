<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Contracts\Providers;

use Phalcon\Di;

/**
 * A provider interface, dedicated for module insertion.
 */
interface ModuleInterface
{
    /**
     * Execute scripts after module run.
     *
     * @return void
     */
    public function afterModuleRun();
}
