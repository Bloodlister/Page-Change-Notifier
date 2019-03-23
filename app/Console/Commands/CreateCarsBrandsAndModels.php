<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use App\Car\Retriever\CarsBg;

class CreateCarsBrandsAndModels extends Command
{

    const BASE_CONFIG_LOCATION = 'storage/app/carsBGConfigs';

    /** @var string $identifier */
    private $identifier;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carsBG:config {identifier}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recreates the json files which the carsBG portion uses to get it\'s brands and models';

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
        $this->identifier = $this->argument('identifier');
        $fileSys = new Filesystem();

        $brandIds = $this->getBrandIds($fileSys);
        $models = $this->getModels($brandIds);

        $this->saveModels($fileSys, $models);

        return true;
    }

    public function getBrandIds(Filesystem $fileSys) {
        $json = $fileSys->get('resources/js/components/searches/data/' . $this->identifier . '.js');
        $json = trim(trim(str_replace('export default', '', $json)), ';');

        $brands = json_decode($json ,true)['inputs']['brands'];
        return array_keys($brands);
    }

    public function getModels($brandIds) {
        $models = [];

        foreach($brandIds as $brandId) {
            $models[$brandId] = CarsBG::getModels($brandId)->toArray();
        }

        return $models;
    }

    public function saveModels(Filesystem $fileSys, $models) {
      $modelsJson = json_encode($models);

      $fileSys->put(self::BASE_CONFIG_LOCATION . '/' . $this->identifier . '.json', $modelsJson);
    }
}





























