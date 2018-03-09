<?php

namespace Saeno\Util\Composer;

/**
 * {@inheritdoc}
 */
class TestConsole extends Console
{
    /**
     * @var string
     */
    protected $name = 'composer:test';

    /**
     * @var string
     */
    protected $description = 'Testing';

    /**
     * {@inheritdoc}
     */
    public function slash()
    {
        $builder = new Builder;
        $builder->config(
            file_get_contents(base_path('composer.json'))
        );

        $builder->set('name', 'saeno/app');
        $builder->merge('require', [
            'saeno/framework' => '1.4.*',
        ]);

        $validation = $builder->validate();

        if (! $validation['valid']) {
            if (isset($validation['publish_error'])) {
                throw new \Exception('Publish Error found '.json_encode($validation['publish_error']));
            }

            if (isset($validation['error'])) {
                throw new \Exception('Error found '.json_encode($validation['error']));
            }
        }

        file_put_contents(base_path('composer.json'), $builder->render());
    }
}
