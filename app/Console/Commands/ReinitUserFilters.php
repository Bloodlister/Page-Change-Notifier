<?php

namespace App\Console\Commands;

use App\Filter;
use App\User;
use Illuminate\Console\Command;

class ReinitUserFilters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reinit {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears all of users filters and recreates them';

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
        $userId = $this->argument('user_id');
        /** @var User $user */
        $user = User::find($userId);
        $bar = $this->output->createProgressBar($user->filters()->count());
        $user->filters()->each(function (Filter $filter) use ($userId, $bar) {
            $newFilter = new Filter();
            $newFilter->user_id = $userId;
            $newFilter->search_params = $filter->search_params;
            $newFilter->type = $filter->type;
            $filter->delete();
            $newFilter->save();
            $bar->setMessage('Last Filter Type: ' . $filter->type . ' ID: ' . $filter->id);
            $bar->advance();
        });

        $bar->finish();
    }
}
