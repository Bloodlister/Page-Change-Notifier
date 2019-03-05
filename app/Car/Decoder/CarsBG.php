<?php

namespace App\Car\Decoder;

use App\Car;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class CarsBG extends Decoder {

    public const IDENTIFIER = 'CarsBG';

    public static function getModels($html) {
        $models = collect();

        $crawler = new Crawler($html);
        try {
              $crawler->filter('li')->each(function(Crawler $item) use (&$models) {
                $model = $item->filter('label')->first()->text();
                $modelId = $item->filter('input')->first()->attr('value');
                if (is_numeric($modelId)) {
                    $models[$modelId] = $model;
                }
            });
        } catch (Exception $e) {}

        return $models;
    }

    protected function getCarsHTMLFromPage(string $pageHTML) : Collection {

    }

    protected function getCarFromHTML(string $html) : Car {

    }
}
