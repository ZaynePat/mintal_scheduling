<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->get();
        return view('activity-log.activity_logs', compact('logs'));
    }
}
