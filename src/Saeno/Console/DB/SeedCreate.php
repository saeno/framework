<?php

/**
 * Saeno\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/saeno/framework
 */

namespace Saeno\Console\DB;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Create a database seeder.
 */
class SeedCreate extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'seed:create';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new database seeder';

    /**
     * {@inheritdoc}
     */
    protected $help = "\nCreates a new database seeder\n";

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        # get the seed path from the config
        $path = realpath($this->getSeedPath());

        if (! file_exists($path)) {
            if ($this->confirm('Create migrations directory? [y]/n ', true)) {
                mkdir($path, 0755, true);
            }
        }

        $this->verifySeedDirectory($path);

        $class_name = $this->getInput()->getArgument('name');

        $this->checkValidPhinxClassName($class_name);

        // Compute the file path
        $file_path = $path.'/'.$class_name.'.php';

        if (is_file($file_path)) {
            throw new \InvalidArgumentException(sprintf(
                'The file "%s" already exists',
                basename($file_path)
            ));
        }

        # inject the class names appropriate to this seeder
        $contents = file_get_contents($this->getSeedTemplateFilename());

        $classes = [
            '$useClassName'  => 'Saeno\Support\Phinx\Seed\AbstractSeed',
            '$className'     => $class_name,
            '$baseClassName' => 'AbstractSeed',
        ];

        $contents = strtr($contents, $classes);

        if (false === file_put_contents($file_path, $contents)) {
            throw new \RuntimeException(sprintf(
                'The file "%s" could not be written to',
                $path
            ));
        }

        $this->getOutput()->writeln('<info>using seed base class</info> '.$classes['$useClassName']);
        $this->getOutput()->writeln('<info>created</info> .'.str_replace(getcwd(), '', $file_path));
    }

    /**
     * {@inheritdoc}
     */
    public function arguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'What is the name of the seeder?'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSeedTemplateFilename()
    {
        $file = url_trimmer(config()->path->storage.'/stubs/db/SeedCreate.stub');

        if (! file_exists($file)) {
            throw new \RuntimeException("Seed Template [$file] not found.");
        }

        return $file;
    }

    /**
     * Get the confirmation question asking if the user wants to create the
     * seeds directory.
     *
     * @return ConfirmationQuestion
     */
    protected function getCreateSeedDirectoryQuestion()
    {
        return new ConfirmationQuestion('Create seeds directory? [y]/n ', true);
    }

    /**
     * Get the question that allows the user to select which seed path to use.
     *
     * @param string[] $paths
     * @return ChoiceQuestion
     */
    protected function getSelectSeedPathQuestion(array $paths)
    {
        return new ChoiceQuestion('Which seeds path would you like to use?', $paths, 0);
    }

    /**
     * Returns the seed path to create the seeder in.
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getSeedPath()
    {
        $paths = $this->getDefaultConfig()->getSeedPaths();

        // No paths? That's a problem.
        if (empty($paths)) {
            throw new \Exception('No seed paths set in your Phinx configuration file.');
        }

        $paths = \Phinx\Util\Util::globAll($paths);

        if (empty($paths)) {
            throw new \Exception(
                'You probably used curly braces to define seed path in your Phinx configuration file, ' .
                'but no directories have been matched using this pattern. ' .
                'You need to create a seed directory manually.'
            );
        }

        // Only one path set, so select that:
        if (1 === count($paths)) {
            return array_shift($paths);
        }

        // Ask the user which of their defined paths they'd like to use:
        $helper = $this->getHelper('question');
        $question = $this->getSelectSeedPathQuestion($paths);

        return $helper->ask($this->getInput(), $this->getOutput(), $question);
    }
}

