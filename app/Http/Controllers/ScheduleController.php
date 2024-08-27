<?php
namespace App\Http\Controllers;

use App\Exports\SchedulesExport;
use App\Http\Requests\ScheduleRequest;
use App\Models\Block;
use App\Models\Classroom;
use App\Models\Faculty;
use App\Models\Schedule;
use App\Models\Subject;
use App\Services\AcademicCalendarService;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $currentSemester;
    protected $currentYear;

    public function __construct(AcademicCalendarService $academicCalendarService)
    {
        $this->currentSemester = $academicCalendarService->getCurrentSemester();
        $this->currentYear = $academicCalendarService->getCurrentYear();
    }

    public function index()
    {
        $schedules = Schedule::with([
            'faculty',
            'semester',
            'school_year',
            'subject',
            'classroom',
            'block',
            'time_slots'
        ])->where('semesters_id', '=', $this->currentSemester)->get()->sortBy('faculty.first_name');

        return view('schedule.table-schedule', compact('schedules'));
    }

    public function create()
    {
        $faculties = Faculty::select('*')->orderBy('first_name')->get();
        $subjects = Subject::select('*')->orderBy('subject_code')->get();
        $classrooms = Classroom::select('*')->orderBy('building')->get();
        $blocks = Block::select('*')->orderBy('course')->get();
        $schedules = Schedule::with([
            'faculty',
            'semester',
            'school_year',
            'subject',
            'classroom',
            'block',
            'time_slots'
        ])->where('semesters_id', '=', $this->currentSemester)->get()->sortBy('faculty.first_name');

        return view('schedule.form-schedule', compact([
            'faculties',
            'subjects',
            'classrooms',
            'blocks',
            'schedules',
        ]))->with(['action' => 'add']);
    }

    public function store(ScheduleRequest $request, ScheduleService $scheduleService)
    {
        $data = $request->except(['sy_id', 'semesters_id', '_token']);

        $result = $scheduleService->createSchedule($data, $this->currentSemester, $this->currentYear);

        if ($result['success']) {
            return redirect()->route('schedule.index')->with('message', 'New schedule added!');
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);

        $faculties = Faculty::orderBy('first_name')->get();
        $subjects = Subject::orderBy('subject_code')->get();
        $classrooms = Classroom::orderBy('building')->get();
        $blocks = Block::orderBy('course')->get();
        $schedules = Schedule::with([
            'faculty',
            'semester',
            'school_year',
            'subject',
            'classroom',
            'block',
            'time_slots'
        ])->where('semesters_id', '=', $this->currentSemester)->get()->sortBy('faculty.first_name');

        $timeSlot = $schedule->time_slots()->firstOr();

        return view('schedule.form-schedule', compact([
            'schedule',
            'faculties',
            'subjects',
            'classrooms',
            'blocks',
            'timeSlot',
            'schedules'
        ]))->with(['action' => 'update']);
    }

    public function update(ScheduleRequest $request, string $id, ScheduleService $scheduleService)
    {
        $data = $request->except(['sy_id', 'semesters_id', '_token']);

        $result = $scheduleService->updateSchedule($data, $id, $this->currentSemester);

        if ($result['success']) {
            return redirect()->route('schedule.index')->with('message', 'Schedule Updated!');
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    public function destroy(string $id)
    {
        Schedule::findOrFail($id)->delete();

        return redirect()->route('schedule.index')->with('message', 'Schedule Deleted!');
    }

    public function export()
    {
        return (new SchedulesExport)->download('Tentative_Faculty_Load.xlsx');
    }
}
