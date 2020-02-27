<?php

namespace Anomaly\Streams\Platform\Testing\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Finder\Finder;

class LoadConfiguration extends \Orchestra\Testbench\Bootstrap\LoadConfiguration
{

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     *
     * @return array
     */
    protected function getConfigurationFiles(Application $app): array
    {
        $files = [];

        $path = \realpath(__DIR__.'/../../../tests/laravel/config');

        foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
            $files[\basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }
}
