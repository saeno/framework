<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * This provider register all the assigned consoles which basically
 * manages them and injecting those to be part of the commands.
 */
class Console extends ServiceProvider
{
    /**
     * The current system version.
     */
    const VERSION = 'v1.5.x-dev';

    /**
     * The console description which holds the copywright.
     */
    const DESCRIPTION = 'Brood (c) Daison Cariño';

    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Get all this service provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return ['console'];
    }

    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->bind('console', function () {
            $app = new ConsoleApplication(static::DESCRIPTION, static::VERSION);

            if (is_cli()) {
                foreach (config()->consoles as $console) {
                    $app->add(new $console);
                }
            }

            return $app;
        });
    }
}
