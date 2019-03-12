<?php

namespace App\Car\Retriever;

use App\Helpers\Request;
use App\Car\Collection\Base;
use Illuminate\Support\Collection;
use App\Car\Decoder\Factory as DecoderFactory;
use Mockery\Exception;

class MobileBG extends Retriever {
    const IDENTIFIER = 'MobileBG';

    public function getCars(Base $collection, int $page = 1) : Collection {
        $cars = $this->getCarsFromSearch($collection, $page);

        if ($cars->count() > 0) {
            $collection->addCars($cars);
        }

        if ($cars->count() == 0 || $collection->initialLimitReached()) {
            return $collection->getCars();
        } else {
            $page += 1;
            return $this->getCars($collection, $page);
        }
    }

    /**
     * @param Collection                       $seenCars
     * @param \App\Car\Collection\MobileBG|Base $collection
     * @param int                              $page
     * @return Collection
     * @throws \Exception
     */
    public function getNewCars(Collection $seenCars, Base $collection, int $page = 1) : Collection {
        $cars = $this->getCarsFromSearch($collection, $page);

        if ($cars->count() > 0) {
            $collection->addNewCars($seenCars, $cars);
        }

        if ($cars->count() == 0 || $collection->seenPreviousCars()) {
            return $collection->getCars();
        } else {
            $page += 1;
            return $this->getNewCars($seenCars, $collection, $page);
        }
    }

    /**
     * @param \App\Car\Collection\MobileBG|Base           $collection
     * @param                                            $page
     * @return Collection
     * @throws \Exception
     */
    private function getCarsFromSearch(Base $collection, $page) {
        if (!$collection->getSlink()) {
            $slink = $this->getSlink($collection->getSearchParams());
            while (!is_string($slink)) {
                static $count = 0;
                $count++;
                if ($count > 5) {
                    throw new \Exception("Could not get slink");
                }

                $slink = $this->getSlink($collection->getSearchParams());
            }
            $collection->setSlink($slink);
        }

        $resultsHTML = $this->getCarsHTMLFromSlink($collection->getSlink(), $page);
        return DecoderFactory::get(static::IDENTIFIER)->getCars($resultsHTML);
    }

    public function getSlink($searchParams, $repeat = 0) {
        $headers = $this->getHeaders($searchParams);
        if (!isset($headers['location']) && $repeat < 5) {
            $repeat += 1;
            return $this->getSlink($searchParams, $repeat);
        } else if (!isset($headers['location']) && $repeat >= 5) {
            throw new \Exception('a');
        }
        foreach ($headers['location'] as $header) {
            if (!empty(preg_match('/slink=(.+)&/', $header, $matches))) {
                return $matches[1];
            }
        }
    }

    public function getHeaders($searchParams) {
        $ch = curl_init();
        $headers = [];
        curl_setopt($ch, CURLOPT_URL, 'https://mobile.bg/pcgi/mobile.cgi');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, Request::urlencode($searchParams));
        curl_setopt($ch, CURLOPT_POSTREDIR, 3);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2)
                    return $len;

                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $headers))
                    $headers[$name] = [trim($header[1])];
                else
                    $headers[$name][] = trim($header[1]);

                return $len;
            }
        );

        curl_exec($ch);
        curl_close($ch);
        return $headers;
    }

    private function getCarsHTMLFromSlink(String $slink, int $page) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://mobile.bg/pcgi/mobile.cgi?act=3&slink=' . $slink . "&f1=" . $page);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}