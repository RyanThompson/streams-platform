<?php

namespace Anomaly\Streams\Platform\Testing;

use Anomaly\FlowTheme\FlowThemeServiceProvider;
use Anomaly\Streams\Platform\StreamsServiceProvider;
use Anomaly\Streams\Platform\Testing\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Application;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $providers = [];

    protected $facades = [];

    protected function getBasePath()
    {
        return __DIR__ .'/../../tests/laravel';
    }

    protected function resolveApplication()
    {
        return \tap(new Application($this->getBasePath()), static function ($app) {
            $app->bind(
                'Illuminate\Foundation\Bootstrap\LoadConfiguration',
                'Anomaly\Streams\Platform\Testing\Bootstrap\LoadConfiguration'
            );
        });
    }

    protected function getPackageProviders($app)
    {
        $providers = [
            FlowThemeServiceProvider::class,
            StreamsServiceProvider::class,
        ];
        return array_unique(array_merge($providers, $this->providers));
    }

    protected function getPackageAliases($app)
    {
        $facades = [
        ];
        return array_merge($facades, $this->facades);
    }

    protected function setUp(): void
    {
        parent::setUp();
//        $this->artisan('install', ['--ready' => true, '--no-interaction' => true]);
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app[ 'config' ]->set('database.default', 'testing');
        $app[ 'config' ]->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
