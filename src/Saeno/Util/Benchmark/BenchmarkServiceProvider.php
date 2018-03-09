<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Util\Benchmark;

use Saeno\Providers\ServiceProvider;

/**
 * This provider manages all class aliases.
 */
class BenchmarkServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Get service provider's provides.
     *
     * @return array
     */
    public function provides()
    {
        return ['benchmark'];
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('benchmark', function () {
            return new Benchmark(SAENO_START);
        });
    }
}
