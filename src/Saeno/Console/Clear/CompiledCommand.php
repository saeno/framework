<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Console\Clear;

use Saeno\Console\Brood;

/**
 * A console command that clears compiled.php file.
 */
class CompiledCommand extends Brood
{
    use ClearTrait;

    /**
     * {@inheritdoc}
     */
    protected $name = 'clear:compiled';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Clear the compiled classes';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $this->clear(
            url_trimmer(storage_path('saeno'))
        );
    }
}
