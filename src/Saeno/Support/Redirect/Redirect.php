<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Support\Redirect;

use Saeno\Support\WithMagicMethodTrait;

/***
 * Class Redirect
 * @package Saeno\Support\Redirect
 *
 * @method withError(string $message) write error flash message
 * @method withSuccess(string $message) write success flash message
 */
class Redirect
{
    use WithMagicMethodTrait;

    /**
     * Redirect based on the provided url.
     *
     * @param string $url
     * @return mixed|\Saeno\Support\Redirect\Redirect
     */
    public function to($url)
    {
        resolve('response')->redirect($url);

        return $this;
    }

    /**
     * Passing a query param.
     *
     * @param string $key
     * @param string $value
     * @return mixed|\Saeno\Support\Redirect\Redirect
     */
    public function with($key, $value)
    {
        resolve('flash')->session()->message($key, $value);

        return $this;
    }
}
