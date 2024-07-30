<?php

namespace Itszun\Citadel;

use Illuminate\Support\ServiceProvider;

class CitadelServiceProvider extends ServiceProvider {
    
    public function boot() {
        $this->loadViewsFrom("\\views", 'citadel');
        $this->loadRoutesFrom("\\routes\\citadel.php");
        $this->mergeConfigFrom("\\config\\citadel.php", 'citadel');
    }
}