<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // --- BYPASS CACHE WASMER ---
        // Kode ini akan menimpa cache yang terkunci secara paksa
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => 'db.fr-roub1.bengt.wasmernet.com',
            'database.connections.mysql.port' => '20184',
            'database.connections.mysql.database' => 'db_9b1ae70a',
            'database.connections.mysql.username' => 'user_d2717e1e',
            'database.connections.mysql.password' => 'Mpw_Ls293ey8AINanXMSzKq57CTBDUAkFtqU',
            
            // Bypass session agar tidak error saat baca database
            'session.driver' => 'cookie', 
            
            // PAKSA MENGGUNAKAN SSL UNTUK AIVEN CLOUD
            'database.connections.mysql.options' => extension_loaded('pdo_mysql') ? [
                \PDO::MYSQL_ATTR_SSL_CA => storage_path('ca.pem'),
            ] : [],
        ]);
    }
}