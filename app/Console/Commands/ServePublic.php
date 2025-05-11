<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServePublic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the development server and open the browser to the public pages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = '127.0.0.1';
        $port = 8000;
        $url = "http://{$host}:{$port}";

        $this->info("Starting Laravel development server: {$url}");
        $this->info("Press Ctrl+C to stop the server");

        // Open browser in background
        $this->openBrowser($url);

        // Start development server
        $process = new Process(['php', 'artisan', 'serve']);
        $process->setTimeout(null);
        $process->setTty(true);
        $process->run();

        return Command::SUCCESS;
    }

    /**
     * Open the browser to the given URL.
     */
    protected function openBrowser(string $url): void
    {
        $os = PHP_OS;

        // Wait a moment for the server to start
        sleep(1);

        if (str_contains($os, 'WIN')) {
            // Windows
            exec("start {$url}");
        } elseif (str_contains($os, 'Darwin')) {
            // Mac OS
            exec("open {$url}");
        } else {
            // Linux
            exec("xdg-open {$url}");
        }

        $this->info("Opening browser to {$url}");
    }
}
