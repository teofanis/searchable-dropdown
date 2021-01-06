<?php

namespace Teofanis\SearchableDropdown;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SearchableDropdownServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      $this->loadViewsFrom(__DIR__.'/views/components', 'searchableDropdown');
      Blade::component('searchableDropdown::dropdown', 'searchable-dropdown');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(File::exists(__DIR__.'/helpers.php')){
          require __DIR__.'/helpers.php';
        }
        Blade::directive('searchableDropdownScripts', function(){
          return "{!! view('searchableDropdown::partials.searchable-dropdown-scripts')->render(); !!}";
        });
    }
}
