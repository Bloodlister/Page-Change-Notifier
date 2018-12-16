<?php /** @noinspection ALL */

namespace App\CarRetriever;

use Illuminate\Support\Collection;

class MobileBG extends Retriever {
    const IDENTIFIER = 1;

    public function getCars(array $searchParams, int $page = 1) : Collection {

    }

    public function getSlink($searchParams) {
        $headers = $this->getHeaders();
    }

    public function getHeaders($searchParams) {
        $ch = curl_init();
        $headers = [];
        curl_setopt($ch, CURLOPT_URL, 'https://mobile.bg/pcgi/mobile.cgi');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($searchParams));

        // this function is called by curl for each header received
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            /** @noinspection PhpComposerExtensionStubsInspection */
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
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
        return $headers;
    }
}