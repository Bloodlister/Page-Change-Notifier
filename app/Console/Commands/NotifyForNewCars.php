<?php

namespace App\Console\Commands;

use App\Car\Collection\MobileBG as MBGCollection;
use App\Car\Retriever\MobileBG as MBGRetriever;
use App\Filter;
use App\Mail\NewCars;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class NotifyForNewCars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier:MobileBG {cssPath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the users the new cars in their specified filters';

    /** @var Collection $newCars */
    private $newCars;

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
            //Resetting the new cars
            $this->newCars = collect();
            $retriever = new MBGRetriever();
            $collection = new MBGCollection();

            $user->filters()->each(function (Filter $filter) use ($retriever, $collection) {
                $collection->setSearchParams($filter->search_params);
                $seenCarLinks = collect();
                $filter->seenCars()->get()->each(function($car) use ($seenCarLinks) {
                    $seenCarLinks->push($car->link);
                });
                $newCarsFromFilter = $retriever->getNewCars($seenCarLinks, $collection, 1);
                $this->newCars = $this->newCars->concat($newCarsFromFilter);
            });

            $newCarsMail = new NewCars($this->newCars, $this->argument('cssPath'));
            Mail::to('bloodlisterer@gmail.com')->send($newCarsMail);
        });
    }
}
