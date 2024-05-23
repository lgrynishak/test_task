<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\Job;

class UpdateJobStateListener
{
    public function handle(Job $job, $data): void
    {
    }
}
