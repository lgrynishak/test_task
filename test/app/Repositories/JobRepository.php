<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class JobRepository implements JobRepositoryInterface
{
    public function createJob(string $jobClass, Carbon $scheduledFor): void
    {
        DB::table('jobs')->insert([
            'job_class' => $jobClass,
            'created_at' => now(),
            'scheduled_for' => $scheduledFor->toDateTimeString(),
        ]);
    }

    public function getJobs(int $limit): Collection
    {
        return DB::table('jobs')
            ->select([
                'created_at',
                'scheduled_for',
                DB::raw('CASE WHEN scheduled_for > NOW() THEN 0 ELSE 2 END AS state'),
            ])
            ->take($limit)
            ->get();
    }
}
