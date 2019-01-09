<?php

namespace Platform\Console;

use Illuminate\Console\Command;

class PlatformInstallConsole extends Command
{
    /**
     * @var string
     */
    protected $signature = 'sciice:install';

    /**
     * @var string
     */
    protected $description = 'Install all of the Platform resources';

    /**
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Platform Resources...');
        $this->callSilent('vendor:publish', [
            '--tag'   => 'admin-config',
            '--force' => true,
        ]);

        $this->comment('Generate a jwt-auth secret.');
        $this->callSilent('jwt:secret');
        $this->callSilent('vendor:publish', [
            '--provider' => 'Tymon\JWTAuth\Providers\LaravelServiceProvider',
        ]);

        $this->registerServiceProvider();

        $this->info('installed successfully.');
    }

    /**
     * @return void
     */
    protected function registerServiceProvider()
    {
        file_put_contents(config_path('app.php'), str_replace(
            "App\Providers\EventServiceProvider::class,".PHP_EOL,
            "App\Providers\EventServiceProvider::class,".PHP_EOL."        Platform\Providers\SciiceServiceProvider::class,".PHP_EOL,
            file_get_contents(config_path('app.php'))
        ));
    }
}
