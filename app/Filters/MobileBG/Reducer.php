<?php

namespace App\Filters\MobileBG;

class Reducer {

    public $link;

    public $image;

    public $price;

    public $title;

    public $description;

    public function __construct(string $carHTML) {
        $this->setLink($carHTML);
        $this->setTitle($carHTML);
        $this->setDescription($carHTML);
        $this->setImage($carHTML);
        $this->setPrice($carHTML);
    }

    private function setImage(string $carHTML) {
    }

    private function setTitle(string $carHTML) {
    }

    private function setDescription(string $carHTML) {
    }

    private function setLink(string $carHTML) {
    }

    private function setPrice(string $carHTML) {
    }

}