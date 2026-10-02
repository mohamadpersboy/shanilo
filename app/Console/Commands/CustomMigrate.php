<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CustomMigrate extends Command
{
    const PATHS=[
        '/database/migrations/base',
        '/database/migrations/specific',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrateFolder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migration command for subdirectories';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (self::PATHS as $path){
            $this->call('migrate',[
                '--path'=>$path
            ]);
        }
    }
}
