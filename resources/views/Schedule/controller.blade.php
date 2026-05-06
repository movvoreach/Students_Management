 public function index(Request $request)
    {
        $user = Auth::user();

        $query = Schedule::with(['teacher', 'class', 'subject']);

        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');

            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)->value('department_id');

            $query->where('department_id', $departmentId);

        } elseif ($user->hasRole('admin')) {

            $query = $this->scheduleService->getWithsearchFilters($request->all(), $user);
        }

        $data = (clone $query)
            ->orderByRaw("TIME(start_time) ASC")
            ->get();

        $times = (clone $query)
            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')
            ->orderByRaw("TIME(start_time) ASC")
            ->get();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $schedules = [];

        foreach ($times as $pkey => $time) {
            $schedules[$pkey]['time'] =
            \Carbon\Carbon::parse($time->start_time)->format('h:i A')
            . ' - ' .
            \Carbon\Carbon::parse($time->end_time)->format('h:i A');

            foreach ($days as $day) {
                $rows = $data
                    ->where('day', $day)
                    ->where('start_time', $time->start_time)
                    ->where('end_time', $time->end_time);

                $schedules[$pkey][$day] = $rows;
            }
        }

        $departments = Department::all();
        $classes     = Classroom::all();

        return view('Schedule.index', compact(
            'schedules',
            'days',
            'departments',
            'classes'
        ));
    }
