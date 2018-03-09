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
 * Get the 'annotations' service provider.
 */
class Annotations extends ServiceProvider
{
    /**
     * {@inheridoc}.
     */
    public function register()
    {
        $this->app->singleton('annotations', function () {

            $adapters = config('annotation.adapters');
            $selected_adapter = config()->app->annotation_adapter;

            if (isset($adapters[$selected_adapter])) {
                $conf = $adapters[$selected_adapter];
                return new $conf['class']($conf['options'] ?? []);
            }

            // fallback adapter
            return new \Phalcon\Annotations\Extended\Adapter\Memory();
        });
    }
}
