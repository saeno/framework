<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Console\DB;

use Phinx\Util\Util;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Create a db migration.
 */
class Create extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'db:create';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new migration';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $path = realpath($this->getDefaultConfig()->getMigrationPath());

        if (! file_exists($path)) {
            if ($this->confirm('Create migrations directory? [y]/n ', true)) {
                mkdir($path, 0755, true);
            }
        }

        $this->verifyMigrationDirectory($path);

        $class_name = $this->getInput()->getArgument('name');

        $this->checkValidPhinxClassName($class_name);

        $this->checkUniqueMigrationClassName($class_name, $path);

        $file_name = $this->mapClassNameToFileName($class_name);
        $file_path = $path.'/'.$file_name;

        $contents = file_get_contents($this->getMigrationTemplateFilename());

        $contents = strtr($contents, [
            '$useClassName'  => $this->getMigrationBaseClassName(false),
            '$className'     => $class_name,
            '$version'       => Util::getVersionFromFileName($file_name),
            '$baseClassName' => $this->getMigrationBaseClassName(true),
        ]);

        if (false === file_put_contents($file_path, $contents)) {
            throw new \RuntimeException(sprintf(
                'File "%s" could not be written',
                $file_path
            ));
        }

        $this->getOutput()->writeln('<info>created</info> '.str_replace(getcwd(), '', $file_path));
    }

    /**
     * {@inheritdoc}
     */
    public function arguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'What is the name of the migration?'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getMigrationTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/MigrationCreate.stub');

        if (! file_exists($file)) {
            throw new \RuntimeException("Migration Template [$file] not found.");
        }

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    protected function mapClassNameToFileName($class_name)
    {
        return Util::mapClassNameToFileName($class_name);
    }

    /**
     * {@inheritdoc}
     */
    protected function getMigrationBaseClassName($drop_namespace = fakse)
    {
        $class_name = \Saeno\Support\Phinx\Migration\AbstractMigration::class;

        return $drop_namespace ? substr(strrchr($class_name, '\\'), 1) : $class_name;
    }
}
