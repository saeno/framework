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
 * A swift mail adapter.
 */
class MailMailer extends Swift
{
    /**
     * {@inheritdoc}
     */
    protected function getTransport()
    {
        return \Swift_MailTransport::newInstance();
    }

    /**
     * {@inheritdoc}
     */
    public function encryption($encryption)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function host($host)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function port($port)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function username($username)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function password($password)
    {
        return $this;
    }
}
