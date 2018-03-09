<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Providers;

use Phalcon\Db\Adapter\MongoDB\Client;

/**
 * This provider instantiates the @see \MongoClient.
 */
class Mongo extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $adapters = config('database.nosql_adapters');
        foreach ($adapters as $adapter_name => $adapter_conf) {

            if (empty($adapter_conf)) {
                throw new InvalidArgumentException("The provided settings for nosql adapter [$adapter_name] is invalid.");
            }

            $this->registerAdapterService($adapter_name, $adapter_conf);
        }

        // register default mongo service
        $this->app->singleton('mongo', function () {
            return $this->app->make(config()->app->default_nosql_adapter);
        });
    }

    private function registerAdapterService($adapter_name, $adapter_conf)
    {
        $this->app->singleton($adapter_name, function () use ($adapter_conf) {

            if (!class_exists($adapter_conf['class'])) {
                return $this;
            }

            $options = $adapter_conf['options'];

            // use "uri" as connection string, if exists
            if (isset($options->uri) && !empty($options->uri)) {
                $str = $options->uri;
            } else {
                if (strlen($options->username) < 1 && strlen($options->password) < 1) {
                    $str = 'mongodb://' . $options->host . ':' . $options->port;
                } else {
                    $str = 'mongodb://' . $options->username . ':' . $options->password . '@' . $options->host . ':' . $options->port;
                }
            }

            $mongo_client = new $adapter_conf['class']($str);
            return $mongo_client->selectDatabase($options->dbname);
        });
    }
}