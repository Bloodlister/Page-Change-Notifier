<?php

namespace App\Decoders;

use App\Car;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class MobileBG extends Decoder {

    public const IDENTIFIER = 'MobileBG';

    protected function getCarsHTMLFromPage(string $html) : Collection {
        $crawler = new Crawler($html);
        $carsTables = collect();
        $crawler->filter('form[name="search"]')->first()->filter('table')->each(function($table) use ($carsTables) {
            /** @var Crawler $table */
            if ($table->filter('tbody')->first()->filter('tr')->count() > 6) {
                $carsTables->push($table->html());
            }
        });
        var_dump($carsTables); exit();

        return $carsTables;
    }

    protected function getCarFromHTML(string $html) : Car {
        // TODO: Implement getCarFromHTML() method.
    }
}