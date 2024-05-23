<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Polygon extends Model
{
    protected $table = 'polygons';

    protected $fillable = ['name', 'polygon'];

    public static function savePolygon(string $name, string $polygon): void
    {
        static::updateOrInsert(
            ['name' => $name],
            ['polygon' => DB::raw("ST_GeomFromText('{$polygon}')")]
        );
    }

    public static function findPolygonByCoordinates(float $lat, float $lon): ?Polygon
    {
        return static::select('name')
            ->whereRaw("ST_Intersects(polygon, ST_GeomFromText('POINT($lon $lat)', 0))")
            ->first();
    }

    public static function truncatePolygons(): void
    {
        static::truncate();
    }
}

