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
        } catch (\Exception $e) {}

        return $models;
    }

    protected function getCarsHTMLFromPage(string $pageHTML) : Collection {
        $crawler = new Crawler($pageHTML);
        $carsTables = collect();

        $crawler->filter('.tableListResults')->first()->filter('tr')->each(function(Crawler $row) use ($carsTables) {
            $isAd = (bool)$row->filter('#subscriptionPromoContainer')->count();
            if ($isAd) { return; }

            if($row->filter('td')->count() >= 5) {
                $carsTables->push($row->html());
            }
        });

        return $carsTables;
    }

    protected function getCarFromHTML(string $html) : Car {
        $crawler = new Crawler($html);
        $car = new Car();

        $index = 1;
        $crawler->filter('td')->each(function(Crawler $field) use (&$car, &$index) {
            $method = 'container_' . $index;

            if(method_exists($this, $method)) {
                $this->$method($car, $field);
            }

            $index++;
        });

        return $car;
    }

    private function container_1(Car &$car, Crawler $crawler) {
        $car->image = $this->getImage($crawler);
        $car->link = $this->getLink($crawler);
    }

    private function container_2(Car &$car, Crawler $crawler) {
        $car->title = $this->getTitle($crawler);
        $car->desc = $this->getDesc($crawler);
    }

    private function container_4(Car &$car, Crawler $crawler) {
        $car->price = $this->getPrice($crawler);
    }

    protected function getImage(Crawler $crawler) {
        return $crawler->filter('img')->first()->attr('src');
    }

    protected function getLink(Crawler $crawler) {
        return 'https://cars.bg/' . $crawler->filter('a')->first()->attr('href');
    }

    protected function getTitle(Crawler $crawler) {
        return $crawler->filter('a')->first()->text();
    }

    protected function getDesc(Crawler $crawler) {
        $description = $crawler->filter('div');

        if ($description->count() > 0) {
            return trim($crawler->filter('div')->first()->text());
        } else {
            return '[ Няма описание. . . ]';
        }
    }

    protected function getPrice(Crawler $crawler) {
        return trim(preg_replace('/\s+/', ' ', $crawler->text()));
    }

}
