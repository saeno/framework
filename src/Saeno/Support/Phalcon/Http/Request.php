<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Support\Phalcon\Http;

use Saeno\Support\Curl\RESTful;
use Phalcon\Http\Request as BaseRequest;

/**
 * {@inheritdoc}
 */
class Request extends BaseRequest
{
    /**
     * Request based on a initialized module.
     *
     * @param string $name
     * @return mixed|\Saeno\Support\Curl\RESTful
     */
    public function module($name)
    {
        return new RESTful(url()->getFullUrl($name));
    }
}
