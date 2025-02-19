<?php

namespace Behandam\Response;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BehandamResponseServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('behandam-response')
            ->hasConfigFile();
    }
}
