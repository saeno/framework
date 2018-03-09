<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Console;

/**
 * The 'server' test case.
 */
class ServerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $compiled_file = 'storage/saeno/compiled.php';

        if (file_exists($compiled_file)) {
            di()->get('flysystem')->delete($compiled_file);
        }
    }

    /**
     * Test the 'optimize' console command.
     *
     * @return void
     */
    public function testOptimizeCommand()
    {
        CLI::bash([
            'php brood optimize --force',
        ]);

        $has_file = file_exists(config()->path->storage.'saeno/compiled.php');
        $this->assertTrue($has_file, 'check if classes were generated and compiled');
    }
}
