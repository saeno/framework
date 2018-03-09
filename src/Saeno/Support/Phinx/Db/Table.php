<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Support\Phinx\Db;

use Phinx\Db\Table as PhinxTable;

/**
 * {@inheritdoc}
 */
class Table extends PhinxTable
{
    /**
     * {@inheritdoc}
     */
    public function addSoftDeletes()
    {
        $this
            ->addColumn('deleted_at', 'timestamp', [
                'null' => true,
            ]);

        return $this;
    }
}
