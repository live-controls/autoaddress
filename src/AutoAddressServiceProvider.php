<?php

namespace LiveControls\AutoAddress;

use LiveControls\AutoAddress\Http\Livewire\AutoAddress;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AutoAddressServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    $this->loadTranslationsFrom(__DIR__.'/../lang', 'livecontrols-autoaddress');
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'livecontrols-autoaddress');

    Livewire::component('livecontrols-autoaddress', AutoAddress::class);
  
    $this->publishes([
      __DIR__.'/../lang' => $this->app->langPath('vendor/livecontrols-autoaddress'),
    ], 'livecontrols.autoaddress.localization');

    $this->publishes([
      __DIR__.'/../resources/views' => $this->app->resourcePath('views/vendor/livecontrols-autoaddress')
    ], 'livecontrols.autoaddress.views');

    $this->publishes([
      __DIR__.'/../config/config.php' => config_path('livecontrols_autoaddress.php'),
    ], 'livecontrols.autoaddress.config');
  }
}
