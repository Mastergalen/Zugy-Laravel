<?php

namespace Zugy\Helpers\Maps;


class Maps
{
    protected $apiUrl = 'http://maps.google.com/maps?&q=';

    public function getGoogleMapsUrl($line_1, $line_2 = null, $city, $postcode) {
        $address = [$line_1];

        if($line_2) $address[] = $line_2;

        $address[] = $city;
        $address[] = $postcode;

        return $this->apiUrl . urlencode(implode(', ', $address));
    }
}