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
     /** Register Components */
      $this->loadViewsFrom(__DIR__.'/views/components', 'searchableDropdown');
      Blade::component('searchableDropdown::dropdown', 'searchable-dropdown');
      Blade::component('searchableDropdown::partials.list', 'searchable-dropdown-list');
      Blade::component('searchableDropdown::partials.item', 'searchable-dropdown-list-item');

      
      /** Register Directives */
      Blade::directive('searchableDropdownScripts', function(){
        return '<script src="{{asset(\'/js/searchable-dropdown-scripts.js\')}}"></script>';
      });

      Blade::directive('bindJSInstance', function(){
        return '<script> (function(){ var event = new CustomEvent(\'search-dropdown-ready\', { detail:"{{$dropdownFunctionName}}" }); window.dispatchEvent(event);})(); </script>';
      });
      
      $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'searchable-dropdown-config.php');
      $this->mergeConfigFrom(__DIR__.'/../config/props.php', 'searchable-dropdown-props.php');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      //Load helpers
      if(File::exists(__DIR__.'/helpers.php')){
        require __DIR__.'/helpers.php';
      }  
      /** Config Publishing */
      $this->publishes([__DIR__.'/../config/config.php' => config_path('searchable-dropdown-config.php')], 'searchable-dropdown-config');
      $this->publishes([__DIR__.'/../config/props.php' => config_path('searchable-dropdown-props.php')], 'searchable-dropdown-props');

      /** Asset Publishing */
      $this->publishes([__DIR__.'/assets/js' => public_path('js')],'searchable-dropdown-js');
    }
}
