<?php
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;

class ActivityLogService
{
    public static function log($type, $description)
    {
        ActivityLog::create([
            'activity_type' => $type,
            'description' => $description,
            'user_id' => Auth::id(),
        ]);
    }

    public static function logCreated(Schedule $schedule)
    {
        $data = $schedule->only([
            'faculty_id', 'subject_id', 'block_id', 'classroom_id', 'day'
        ]);

        $timeStart = $schedule->time_slots()->first()->time_start ?? 'N/A';
        $timeEnd = $schedule->time_slots()->first()->time_end ?? 'N/A';

        $description = sprintf(
            'New schedule added: Faculty ID: %d, Subject ID: %d, Block ID: %d, Classroom ID: %d, Day: %s, Time Start: %s, Time End: %s',
            $data['faculty_id'],
            $data['subject_id'],
            $data['block_id'],
            $data['classroom_id'],
            $data['day'],
            $timeStart,
            $timeEnd
        );

        self::log('created', $description);
    }

    public static function logUpdated(Schedule $schedule)
    {
        $data = $schedule->only([
            'faculty_id', 'subject_id', 'block_id', 'classroom_id', 'day'
        ]);

        $timeStart = $schedule->time_slots()->first()->time_start ?? 'N/A';
        $timeEnd = $schedule->time_slots()->first()->time_end ?? 'N/A';

        $description = sprintf(
            'Schedule updated: Faculty ID: %d, Subject ID: %d, Block ID: %d, Classroom ID: %d, Day: %s, Time Start: %s, Time End: %s',
            $data['faculty_id'],
            $data['subject_id'],
            $data['block_id'],
            $data['classroom_id'],
            $data['day'],
            $timeStart,
            $timeEnd
        );

        self::log('updated', $description);
    }

    public static function logDeleted(Schedule $schedule)
    {
        $data = $schedule->only([
            'faculty_id', 'subject_id', 'block_id', 'classroom_id', 'day'
        ]);

        $timeStart = $schedule->time_slots()->first()->time_start ?? 'N/A';
        $timeEnd = $schedule->time_slots()->first()->time_end ?? 'N/A';

        $description = sprintf(
            'Schedule deleted: Faculty ID: %d, Subject ID: %d, Block ID: %d, Classroom ID: %d, Day: %s, Time Start: %s, Time End: %s',
            $data['faculty_id'],
            $data['subject_id'],
            $data['block_id'],
            $data['classroom_id'],
            $data['day'],
            $timeStart,
            $timeEnd
        );

        self::log('deleted', $description);
    }
}
