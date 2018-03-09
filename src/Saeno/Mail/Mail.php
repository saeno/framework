<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Mail;

use Saeno\Contracts\Mail\MailInterface;
use Phalcon\DiInterface;
use Phalcon\Di\InjectionAwareInterface;

/**
 * The mail handler for all available adapters.
 */
class Mail implements InjectionAwareInterface
{
    /**
     * @var mixed|\Saeno\Conctracts\Mail\MailInterface
     */
    private $adapter;

    /**
     * @var array
     */
    private $config;

    /**
     * @var \Phalcon\DiInterface
     */
    protected $_di;

    /**
     * Contructor.
     *
     * @param mixed|\Saeno\Contracts\Mail\MailInterface $adapter
     * @param $config
     */
    public function __construct(MailInterface $adapter, $config)
    {
        $this->adapter = $adapter;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function setDI(DiInterface $di)
    {
        $this->_di = $di;
    }

    /**
     * {@inheritdoc}
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * Intialize the mailer.
     *
     * @param string $view
     * @param array $records
     * @return mixed|\Saeno\Conctracts\Mail\MailInterface
     */
    public function initialize($view, $records)
    {
        # we require our mail to auto-set the configurations
        # in the functions, so we need to call the possible
        # functions that doesn't require human calls
        $functions = [
            'host',
            'port',
            'username',
            'password',
            'encryption',
        ];

        foreach ($functions as $function) {

            # if the provided config is empty, turn next loop
            if (
                ! isset($this->config[$function]) ||
                empty($this->config[$function])
            ) {
                continue;
            }

            # now call the functions
            $this
                ->adapter
                ->{$function}($this->config[$function]);
        }

        # render the view as partial
        $body = di()->get('view')->take($view, $records);

        # we need to insert the global mailer 'from'
        # and insert the body
        $this
            ->adapter
            ->from(isset($this->config['from']) ? $this->config['from'] : '')
            ->body($body);

        # now return the adapter, so that they could still pre-modify
        # the function values
        return $this->adapter;
    }

    /**
     * This will trigger the adapter's send function.
     *
     * @param string $view The view path
     * @param array $records The variables will be used on the view path
     * @param mixed $callback
     *
     * @return bool
     */
    public function send($view, $records, $callback)
    {
        # we will pass the view path and records
        $init = $this->initialize($view, $records);

        # we will call the initialize function
        call_user_func($callback, $init);

        # we lastly triggering the send function
        $init->send();

        return true;
    }
}
