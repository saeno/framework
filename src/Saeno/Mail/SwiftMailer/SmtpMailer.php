<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Mail\SwiftMailer;

/**
 * A swift smtp adapter.
 */
class SmtpMailer extends Swift
{
    /**
     * {@inheritdoc}
     */
    protected function getTransport()
    {
        return \Swift_SmtpTransport::newInstance();
    }
}
