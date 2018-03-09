<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * This provider handles the logging, which by default logs the errors, database
 * transactions.
 */
class Log extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('log', function () {
            $logger = new Logger('saeno');

            $logger_name = 'saeno';

            if ($ext = logging_extension()) {
                $logger_name .= '-'.$ext;
            }

            $logger->pushHandler(
                new StreamHandler(
                    storage_path('logs').'/'.$logger_name.'.log',
                    Logger::DEBUG
                )
            );

            return $logger;
        });
    }
}
