<?php

namespace App\CarRetriever;

use App\CarCollection\CollectionBase;
use App\Helpers\Request;
use Illuminate\Support\Collection;

class MobileBG extends Retriever {
    const IDENTIFIER = 'MobileBG';

    /**
     * @param \App\CarCollection\MobileBG|CollectionBase $collection
     * @param int            $page
     * @return Collection
     */
    public function getCars(CollectionBase $collection, int $page = 1) : Collection {
        if (!$collection->getSlink()) {
            $collection->setSlink($this->getSlink($collection->getSearchParams()));
        }
        $resultsHTML = $this->getCarsHTMLFromSlink($collection->getSlink(), $page);
        $cars = \App\Decoders\Factory::get(static::IDENTIFIER)->getCars($resultsHTML);
//        $collection->addCars();
    }

    public function getSlink($searchParams) {
        $headers = $this->getHeaders($searchParams);
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