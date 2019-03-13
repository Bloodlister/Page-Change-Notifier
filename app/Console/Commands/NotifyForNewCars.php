<?php

namespace App\Console\Commands;

use App\User;
use App\Filter;
use App\Mail\NewCars;
use App\Console\Lockable;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Car\Collection\MobileBG as MBGCollection;
use App\Car\Retriever\MobileBG as MBGRetriever;

class NotifyForNewCars extends Command
{
    use Lockable;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifier:MobileBG {cssPath?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the users the new cars in their specified filters';

    /**
     * @var Collection $newCars
     */
    private $newCars;

    /**
     * @var Collection $allNewCars
     */
    private $allNewCars;

    /**
     * @var string $lockKey
     */
    private static $lockKey = 'GettingNewCars';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Start: ' . (new \DateTime())->format('Y-m-d H:i:s'));
        /** @var Collection $users */
        $users = User::all();

        $users->each(function(User $user) {
            //Resetting the new cars
            $this->allNewCars = collect();
            $this->newCars = collect();
            $retriever = new MBGRetriever();
            $collection = new MBGCollection();

            //Looping though all users
            $user->filters()->where("type", "=", "MobileBG")->each(function (Filter $filter) use ($user, $retriever, $collection) {
                $collection->setSearchParams($filter->search_params); // Setting search params to the collection
                $collection->setSlink(false); // Resetting the slink

                $seenCarLinks = $filter->getSeenCarLinks();

                $newCarsFromFilter = $retriever->getNewCars($seenCarLinks, $collection, 1);
                $newCarsFromFilter = $this->filterOutSeenCars($newCarsFromFilter);

                if ($newCarsFromFilter->isNotEmpty()) {
                    $this->allNewCars = $this->allNewCars->concat($newCarsFromFilter);
                    $this->newCars = $this->newCars->concat($newCarsFromFilter);
                    $filter->seenCars()->saveMany($newCarsFromFilter);
                }

                static $counter = 0;
                $counter++;
                if ($counter > 100) {
                    $this->sendEmailWithCurrentNewCars($user);
                    $this->newCars = collect();
                    $counter = 0;
                }
            });

            if ($this->newCars->isNotEmpty()) {
                $this->sendEmailWithCurrentNewCars($user);
                $this->newCars = collect();
            }
        });
    }

    private function sendEmailWithCurrentNewCars(User $user) {
        if ($this->newCars->isNotEmpty()) {
            if ($this->argument('cssPath') != '') {
                $cssPath = $this->argument('cssPath');
            } else {
                $cssPath = env('APP_URL');
            }
            $newCarsMail = new NewCars($this->newCars, $cssPath);
            Mail::to($user->email)->sendNow($newCarsMail);
        }
    }

    private function filterOutSeenCars(Collection $newCarsFromFilter) {
        foreach ($newCarsFromFilter as $index => $newCarFromFilter) {
            foreach ($this->allNewCars as $newCar) {
                if ($newCar->link == $newCarFromFilter->link) {
                    unset($newCarsFromFilter[$index]);
                }
            }
        }

        return $newCarsFromFilter;
    }
}
