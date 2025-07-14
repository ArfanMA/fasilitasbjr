<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Ruangan;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Registrasi tipe 'enum' sebagai StringType untuk Doctrine DBAL
        if (!Type::hasType('enum')) {
            Type::addType('enum', \Doctrine\DBAL\Types\StringType::class);
        }
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');


        // Bagikan data ruangan ke semua view (misalnya untuk sidebar)
        View::composer('*', function ($view) {
            $ruangan = Ruangan::all();
            $view->with('ruangan', $ruangan);
        });
    }
}
