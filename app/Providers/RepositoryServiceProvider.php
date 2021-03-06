<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();
    }


    /**
     *
     */
    public function registerRepository()
    {
        try {
            $repositories = config('model-service.repositories');
            foreach ($repositories as $repositoryName => $repository) {
                $model = $repository['model'];
                $repository = $repository['repository'];
                $this->app->singleton($repositoryName, function ($app) use ($model, $repository) {
                    $m = new $model();
                    $validator = $app['validator'];
                    return new $repository($m, $validator);
                });
            }
        } catch (\Exception $exception) {
            logInfo('registerRepository注册失败！', $exception->getMessage());
        }
    }
}
