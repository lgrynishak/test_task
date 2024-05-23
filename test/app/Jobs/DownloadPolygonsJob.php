<?php

namespace App\Jobs;

use App\Repositories\PolygonRepositoryInterface;
use App\Services\NominatimApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadPolygonsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(NominatimApiService $apiService, PolygonRepositoryInterface $polygonRepository): void
    {
        $polygonData = $apiService->fetchPolygonData();

        foreach ($polygonData as $item) {
            $polygonRepository->savePolygon($item['name'], $item['geotext']);
        }
    }
}
