<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface JobRepositoryInterface
{
    public function createJob(string $jobClass, Carbon $scheduledFor): void;
    public function getJobs(int $limit): Collection;
}
