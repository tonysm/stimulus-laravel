<?php

namespace Tonysm\StimulusLaravel\Commands\Concerns;

use Illuminate\Support\Facades\File;

/**
 * @mixin \Tonysm\StimulusLaravel\Commands\InstallCommand
 */
trait InstallsForNode
{
    protected function installsForNode()
    {
        $this->publishJsFilesForNode();
    }

    protected function publishJsFilesForNode()
    {
        File::ensureDirectoryExists(resource_path('js/controllers'));
        File::ensureDirectoryExists(resource_path('js/libs'));

        File::copy(__DIR__.'/../../../resources/js/libs/stimulus.js', resource_path('js/libs/stimulus.js'));
        File::copy(__DIR__.'/../../../resources/js/controllers/hello_controller.js', resource_path('js/controllers/hello_controller.js'));
        File::copy(__DIR__.'/../../../resources/js/controllers/index-node.js', resource_path('js/controllers/index.js'));

        $libsIndexFile = resource_path('js/libs/index.js');
        $libsIndexSourceFile = __DIR__.'/../../../resources/js/libs/index-node.js';

        if (File::exists($libsIndexFile)) {
            $importLine = trim(File::get($libsIndexSourceFile));

            if (! str_contains(File::get($libsIndexFile), $importLine)) {
                File::append($libsIndexFile, $importLine.PHP_EOL);
            }
        } else {
            File::copy($libsIndexSourceFile, $libsIndexFile);
        }
    }
}