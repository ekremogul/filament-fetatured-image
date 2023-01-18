<?php
namespace Ekremogul\FilamentFeaturedImage;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentFeaturedImageServiceProvider extends PluginServiceProvider
{
    protected array $styles = [
        "featured-image" => __DIR__ . '/../resources/dist/featured-image.css'
    ];
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-featured-image')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations();
    }
}
