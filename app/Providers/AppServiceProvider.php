<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the MCP URL globally using config or singleton
        $this->app->singleton('mcp_url', function () {
            return env('MCP_SERVER_URL');
        });

        // Optional: Configure Http client globally with base URL
        Http::macro('mcp', function () {
            return Http::baseUrl(env('MCP_SERVER_URL'))
                ->withHeaders([
                    'Accept' => 'application/json',
                    // 'Authorization' => 'Bearer <your-token-here>', // if needed
                ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceRootUrl(config('app.url'));

        // If you’re using HTTPS tunnel, force HTTPS
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
