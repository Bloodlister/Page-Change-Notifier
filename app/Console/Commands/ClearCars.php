<?php

namespace App\Console\Commands;

use App\Filter;
use App\User;
use Illuminate\Console\Command;

class ClearCars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier:clearCars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the users the new cars in their specified filters';

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
        $users = User::where('id', '<>', '0')->get();
        $users->each(function(User $user) {
            $user->filters()->each(function (Filter $filter) {
                $filter->removeOldCars();
            });
        });
    }
}
