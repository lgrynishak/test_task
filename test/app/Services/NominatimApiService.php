<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NominatimApiService
{
    public function fetchPolygonData(): array
    {
        $response = Http::get('https://nominatim.openstreetmap.org/search.php', [
            'q' => 'oblast, Ukraine',
            'featureType' => 'administrative',
            'accept-language' => 'en',
            'polygon_text' => 1,
            'format' => 'jsonv2',
            'limit' => 24,
        ]);

        return $response->json();
    }
}
