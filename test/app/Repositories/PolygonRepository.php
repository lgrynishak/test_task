<?php

namespace App\Repositories;

use App\Models\Polygon;

class PolygonRepository implements PolygonRepositoryInterface
{
    public function savePolygon(string $name, string $polygon): void
    {
        Polygon::savePolygon($name, $polygon);
    }

    public function findPolygonByCoordinates(float $lat, float $lon): ?object
    {
        return Polygon::findPolygonByCoordinates($lat, $lon);
    }

    public function truncatePolygons(): void
    {
        Polygon::truncatePolygons();
    }
}
