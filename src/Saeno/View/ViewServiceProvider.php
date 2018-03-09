<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\View;

use Phalcon\Events\Event;
use Phalcon\Mvc\View\Engine\Php;
use Saeno\View\Volt\VoltAdapter;
use Saeno\View\Blade\BladeAdapter;
use Saeno\Support\Phalcon\Mvc\View;
use Saeno\Providers\ServiceProvider;

/**
 * The 'view' service provider.
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->app->singleton('view.event_manager', function ($app) {
            $event_manager = $app->make('eventsManager');

            $event_manager->attach('view:afterRender',
                function (
                    Event $event,
                    View $dispatcher,
                    $exception
                ) {
                    $dispatcher->getDI()->get('flash')->session()->clear();
                }
            );

            $app->make('view')->setEventsManager($event_manager);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('view', function () {
            $view = new View;

            $view->setViewsDir(config()->path->views);

            $view->registerEngines([
                '.phtml'     => Php::class,
                '.volt'      => VoltAdapter::class,
                '.blade.php' => BladeAdapter::class,
            ]);

            return $view;
        });
    }
}
