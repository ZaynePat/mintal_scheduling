<?php
namespace App\Observers;

use App\Models\Schedule;
use App\Services\ActivityLogService;

class ActivityLogObserver
{
    public function created(Schedule $schedule)
    {
        ActivityLogService::logCreated($schedule);
    }

    public function updated(Schedule $schedule)
    {
        ActivityLogService::logUpdated($schedule);
    }

    public function deleted(Schedule $schedule)
    {
        ActivityLogService::logDeleted($schedule);
    }
}
