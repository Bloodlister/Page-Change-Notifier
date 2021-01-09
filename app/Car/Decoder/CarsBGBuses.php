<?php

namespace App\Car\Decoder;

use App\Car;
use App\Car as Bus;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class CarsBGBuses extends Decoder {

    public const IDENTIFIER = 'CarsBGBuses';

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
        } catch (\Exception $e) {}

        return $models;
    }

    protected function getCarsHTMLFromPage(string $pageHTML): Collection
    {
        $crawler = new Crawler($pageHTML);
        $carsTables = collect();

        $crawler->filter('.pageContainer .mdc-card')->each(function (Crawler $card) use ($carsTables) {
            $carCrawler = new Crawler($card->html());

            if ($carCrawler->filter('a')->count()) {
                $carsTables->push($card->html());
            }
        });

        return $carsTables;
    }

    protected function getCarFromHTML(string $html): Car
    {
        $crawler = new Crawler($html);
        $car = new Car();

        $car->link = $crawler->filter('a')->first()->attr('href');
        $car->title = $crawler->filter('.card__primary .card__title:not(.price)')->first()->text();
        $crawler->filter('a')->first()->each(function (Crawler $carCrawler) use ($car) {
            preg_match('/(https:\/\/.+)"/', $carCrawler->filter('.mdc-card__media')->first()->attr('style'), $style);
            $car->image = $style[1];
        });
        $descriptionParts = [];
        $crawler->filter('div[class*="mdc-typography--body"]')->each(function (Crawler $descriptionPart) use (&$descriptionParts) {
            $descriptionParts[] = $descriptionPart->text();
        });
        $car->desc = implode(' | ', $descriptionParts);
        $car->price = $crawler->filter('.price')->first()->text();

        return $car;
    }

    protected function getPrice(Crawler $crawler)
    {
        return trim(preg_replace('/\s+/', ' ', $crawler->text()));
    }
}
