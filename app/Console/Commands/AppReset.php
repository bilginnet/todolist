<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Application Reset';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if ($this->confirm('>>>> Do you agree that the application will be reset ? ', true)) {
            Artisan::call('key:generate');
            Artisan::call('migrate:fresh', ['--seed' => true]);

            $this->info('The application has been reset');
            return 1;
        }

        $this->info('Canceled');
        return 0;
    }
}
