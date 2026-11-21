<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Este codigo soluciona el error: SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes
        // Este error suela aparecer por usar versiones de mysql viejas o por usar MariaDB
        Schema::defaultStringLength(191);

        View::composer('template.molde', function ($view) {
            $view->with('systemUpdate', Cache::remember('system-update-info', 300, function () {
                $gitDirectory = base_path();

                try {
                    $process = new Process([
                        'git',
                        '-C',
                        $gitDirectory,
                        'log',
                        '-1',
                        '--format=%H|%h|%cI|%s',
                    ]);
                    $process->run();

                    if (! $process->isSuccessful()) {
                        throw new ProcessFailedException($process);
                    }

                    [$hash, $shortHash, $date, $message] = array_pad(
                        explode('|', trim($process->getOutput()), 4),
                        4,
                        null
                    );

                    return [
                        'hash' => $hash,
                        'short_hash' => $shortHash,
                        'date' => $date ? \Carbon\Carbon::parse($date) : null,
                        'message' => $message,
                    ];
                } catch (\Throwable $exception) {
                    return [
                        'hash' => null,
                        'short_hash' => 'Sin datos',
                        'date' => null,
                        'message' => 'Información Git no disponible',
                    ];
                }
            }));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
