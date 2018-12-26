<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ClearLocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearLocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes all the locks in the app/locks folder';

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
     * @return mixed
     */
    public function handle()
    {
        $fileSys = new Filesystem();
        $fileSys->cleanDirectory('storage/app/locks');
    }
}
