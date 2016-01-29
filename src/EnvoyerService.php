<?php

namespace Ck\Laravel\Envoyer;

use Illuminate\Support\ServiceProvider;

class EnvoyerService extends ServiceProvider {


    /**
     * Booting
     */
    public function boot()
    {

        $configPath = __DIR__ . '/../deploy/envoyer.php';

        $this->mergeConfigFrom($configPath, 'envoyer');

        $this->publishes([
            $configPath => config_path('envoyer.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../Envoy.blade.php' => base_path('Envoy.blade.php'),
        ], 'envoy');
    }

	/**
	 * Register the commands
	 *
	 * @return void
	 */
	public function register()
	{

	}
}
