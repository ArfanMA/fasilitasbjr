<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Ruangan;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL; // ← tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Tambahkan baris ini untuk menghindari mixed content
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        try {
            if (!Type::hasType('enum')) {
                Type::addType('enum', \Doctrine\DBAL\Types\StringType::class);
            }

            Schema::getConnection()->getDoctrineSchemaManager()
                ->getDatabasePlatform()
                ->registerDoctrineTypeMapping('enum', 'string');
        } catch (\Exception $e) {
            \Log::warning('Doctrine type mapping skipped: ' . $e->getMessage());
        }

        View::composer('*', function ($view) {
            try {
                $ruangan = Ruangan::all();
            } catch (\Exception $e) {
                \Log::warning('Ruangan::all() gagal di View Composer: ' . $e->getMessage());
                $ruangan = collect();
            }

            $view->with('ruangan', $ruangan);
        });
    }
}
