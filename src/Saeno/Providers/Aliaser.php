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
 * This provider manages all class aliases.
 */
class Aliaser extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('aliaser', function () {
            foreach (config('app.aliases') as $alias => $class) {
                if (! class_exists($alias)) {
                    \Saeno\Services\Mapper::classAlias($class, $alias);
                }
            }
        });
    }
}
