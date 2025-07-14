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
        // Registrasi tipe enum jika DBAL aktif dan koneksi tersedia
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

        // View composer, tapi aman dari crash kalau DB belum siap
        View::composer('*', function ($view) {
            try {
                $ruangan = Ruangan::all();
            } catch (\Exception $e) {
                \Log::warning('Ruangan::all() gagal di View Composer: ' . $e->getMessage());
                $ruangan = collect(); // Kosongkan jika gagal ambil data
            }

            $view->with('ruangan', $ruangan);
        });
    }
}
