<?php

namespace App\Services;

use App\Jobs\DownloadPolygonsJob;
use App\Repositories\JobRepositoryInterface;
use Illuminate\Support\Collection;

class JobService
{
    public function __construct(private readonly JobRepositoryInterface $jobRepository)
    {
    }

    public function scheduleDownloadPolygonsJob(int $delaySeconds): void
    {
        DownloadPolygonsJob::dispatch()->delay($scheduledForTs = now()->addSeconds($delaySeconds));

        $this->jobRepository->createJob(DownloadPolygonsJob::class, $scheduledForTs);

    }

    public function listJobs(int $limit): ?Collection
    {
        return $this->jobRepository->getJobs($limit);
    }
}

