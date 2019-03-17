<?php

namespace App\Car\Decoder;

use App\Car as Bus;
use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;

class MobileBGBuses extends Decoder {

    public const IDENTIFIER = 'MobileBGBuses';

    protected function getCarsHTMLFromPage(string $html) : Collection {
        $crawler = new Crawler($html);
        $busesTable = collect();
        $crawler->filter('form[name="search"]')->first()->filter('table')->each(function(Crawler $table) use ($busesTable) {
            if ($table->filter('tr')->count() > 6) {
                $busesTable->push($table->html());
            }
        });

        return $busesTable;
    }

    protected function getCarFromHTML(string $html) : Bus {
        $crawler = new Crawler($html);

        $bus = new Bus();
        $bus->link = $this->getLink($crawler);
        $bus->title = $this->getTitle($crawler);
        $bus->desc = $this->getDesc($crawler);
        $bus->price = $this->getPrice($crawler);
        $bus->image = $this->getImage($crawler);
        $bus->isTopOffer = $this->getIsTopOffer($crawler);

        return $bus;
    }

    private function getImage(Crawler $crawler) {
        $imageLink = $crawler->filter('img[data-geo]')->each(function($elem) {
            return $elem;
        });

        if (count($imageLink) > 0) {
            $imageLink = $crawler->filter('img[data-geo]')->first()->attr('src');
        } else {
            return 'www.mobile.bg/images/picturess/photo_med1.gif';
        }
        if (starts_with($imageLink, '//')) {
            $imageLink = substr($imageLink, 2);
        }

        return 'https://' . $imageLink;
    }

    private function getTitle(Crawler $crawler) {
        return $crawler->filter('.mmm')->first()->text();
    }

    private function getDesc(Crawler $crawler) {
        return trim(strip_tags($crawler->filter('tr')->getNode(3)->textContent));
    }

    private function getPrice(Crawler $crawler) {
        return $crawler->filter('.price')->first()->text();
    }

    private function getLink(Crawler $crawler) {
        $link = $crawler->filter('.mmm')->first()->attr('href');
        if (starts_with($link, '//')) {
            $link = substr($link, 2);
        }

        return preg_replace('/&slink=[^&]*/i', '', $link);
    }

    private function getIsTopOffer(Crawler $crawler) {
        return $crawler->filter('img[alt="top"]')->count() > 0 ? true : false;
    }
}
