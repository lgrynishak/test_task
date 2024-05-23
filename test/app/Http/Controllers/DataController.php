<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListJobsRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Repositories\PolygonRepositoryInterface;
use App\Services\JobService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class DataController extends Controller
{
    private const ACTION_REFRESH = 'refresh';
    private const ACTION_LIST = 'list';
    private const ACTION_SEARCH = 'search';

    public function __construct(
        private readonly PolygonRepositoryInterface $polygonRepository,
        private readonly JobService $jobService
    ){
    }

    public function refresh(Request $request): JsonResponse
    {
        if ($request->input('action') === self::ACTION_REFRESH) {
            try {
                $delaySeconds = intval($request->query('delaySeconds'));

                $this->jobService->scheduleDownloadPolygonsJob($delaySeconds);

                return new SuccessResponse();
            } catch (Exception $e) {
                return new ErrorResponse('Failed to schedule job: ' . $e->getMessage(), 500);
            }
        }

        return new ErrorResponse('Invalid action');
    }

    public function listJobs(ListJobsRequest $request): JsonResponse
    {
        if ($request->query('action') === self::ACTION_LIST) {
            try {
                $jobs = $this->jobService->listJobs((int)$request->query('limit'));

                return new SuccessResponse($jobs);
            } catch (Exception $e) {
                return new ErrorResponse('Failed to retrieve jobs: ' . $e->getMessage(), 500);
            }
        }

        return new ErrorResponse('Invalid action');
    }

    public function search(SearchRequest $request): JsonResponse
    {
        if ($request->input('action') === self::ACTION_SEARCH) {
            try {
                $lat = $request->input('lat');
                $lon = $request->input('lon');

                $cacheKey = "geo:$lat:$lon";
                $cached = Cache::get($cacheKey);
                if ($cached) {
                    return new SuccessResponse(['geo' => $cached, 'cache' => 'hit']);
                } else {
                    $oblast = $this->polygonRepository->findPolygonByCoordinates($lat, $lon);
                    $data = ['geo' => ['oblast' => $oblast ? $oblast->name : 'Unknown'], 'cache' => 'miss'];

                    Cache::put($cacheKey, $data['geo'], 3600);

                    return new SuccessResponse($data);
                }
            } catch (Exception $e) {
                return new ErrorResponse('Failed to search polygons: ' . $e->getMessage(), 500);
            }
        }

        return new ErrorResponse('Invalid action');
    }

    public function purge(): JsonResponse
    {
        try {
            $this->polygonRepository->truncatePolygons();
            Cache::flush();

            return new SuccessResponse();
        } catch (Exception $e) {
            return new ErrorResponse('Failed to purge polygons: ' . $e->getMessage(), 500);
        }
    }
}
