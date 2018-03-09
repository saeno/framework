<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Console\Server;

use Saeno\Console\Brood;
use Symfony\Component\Console\Input\InputOption;

/**
 * A console command that serves a module.
 */
class BenchmarkCommand extends Brood
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'benchmark';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Check the system benchmarking calls.';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $table = $this->table(
            ['Name', 'Time (sec)', 'Percentage'],
            $this->getBenchmarks()
        );

        $table->render();
    }

    public function getBenchmarks()
    {
        $records = [];

        $total_sec = 0;

        # iterate the markings
        foreach (resolve('benchmark')->get() as $name => $sec) {
            $total_sec += $sec;

            $records[] = [
                $name,
                $sec,
                0,
            ];
        }

        # update percentage
        foreach ($records as $idx => $record) {
            $record[2] = number_format(($record[1] / $total_sec) * 100, 2);
            $records[$idx] = $record;
        }

        # add the total in the last record
        $records[] = [
            'TOTAL',
            $total_sec,
            null
        ];

        return $records;
    }

    /**
     * {@inheritdoc}
     */
    protected function options()
    {
        return [];
    }
}
