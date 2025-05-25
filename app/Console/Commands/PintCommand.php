<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PintCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pint {--test : Run in test mode} {--dirty : Only fix files with uncommitted changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Laravel Pint code style fixer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $command = base_path('vendor/bin/pint');

        if ($this->option('test')) {
            $command .= ' --test';
        }

        if ($this->option('dirty')) {
            $command .= ' --dirty';
        }

        $this->info('Running Laravel Pint...');

        passthru($command, $exitCode);

        return $exitCode;
    }
}
