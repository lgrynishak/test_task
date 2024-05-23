<?php

namespace App\Repositories;

interface PolygonRepositoryInterface
{
    public function savePolygon(string $name, string $polygon): void;
    public function findPolygonByCoordinates(float $lat, float $lon): ?object;
    public function truncatePolygons(): void;
}
