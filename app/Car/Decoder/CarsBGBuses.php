<?php

namespace App\Car\Decoder;

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

    protected function getCarsHTMLFromPage(string $pageHTML) : Collection {
        $crawler = new Crawler($pageHTML);
        $busesTable = collect();

        $crawler->filter('.tableListResults')->first()->filter('tr')->each(function(Crawler $row) use ($busesTable) {
            $isAd = (bool)$row->filter('#subscriptionPromoContainer')->count();
            if ($isAd) { return; }

            if($row->filter('td')->count() >= 5) {
                $busesTable->push($row->html());
            }
        });

        return $busesTable;
    }

    protected function getCarFromHTML(string $html) : Bus {
        $crawler = new Crawler($html);
        $bus = new Bus();

        $index = 1;
        $crawler->filter('td')->each(function(Crawler $field) use (&$bus, &$index) {
            $method = 'container_' . $index;
            if(method_exists($this, $method)) {
                $this->$method($bus, $field);
            }

            $index++;
        });

        return $bus;
    }

    private function container_1(Bus &$bus, Crawler $crawler) {
        $bus->image = $this->getImage($crawler);
        $bus->link = $this->getLink($crawler);
    }

    private function container_2(Bus &$bus, Crawler $crawler) {
        $bus->title = $this->getTitle($crawler);
        $bus->desc = $this->getDesc($crawler);
    }

    private function container_4(Bus &$bus, Crawler $crawler) {
        $bus->price = $this->getPrice($crawler);
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
