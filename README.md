<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# Working
# Working1
# SMS



    public function getWithRoleUsers($user)
    {
        $query = Schedule::with(['teacher.department', 'class', 'subject'])->withCount('students');

        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');
            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)->value('department_id');
            $query->where('department_id', $departmentId);

        }

        return $query;
    }

    public function getScheduleWithTime($query, $user)
    {
        $query->orderByRaw('TIME(start_time) ASC');

        if ($user->hasRole('admin')) {$data = $query->paginate(10)->withQueryString();
            return [
                'data'       => $data,
                'collection' => collect($data->items()),
            ];}

        $data = $query->get();

        return [
            'data'       => $data,
            'collection' => $data,
        ];
    }

    /**
     * Get distinct time slots
     */
    public function getStartTimesAndEndTimes($user)
    {
        return Schedule::query()->when($user->hasRole('teacher'), function ($q) use ($user) {
            $teacherId = Teacher::where('user_id', $user->id)->value('id');
            $q->where('teacher_id', $teacherId);
        })
            ->when($user->hasRole('student'), function ($q) use ($user) {
                $departmentId = Student::where('user_id', $user->id)->value('department_id');
                $q->where('department_id', $departmentId);
            })
            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')
            ->orderByRaw('TIME(start_time) ASC')
            ->get();
    }

    public function getScheduleWithTimeAndDays($getScheduleWithTime, $getTime, $days)
    {
        $schedules = [];

        foreach ($getTime as $pkey => $time) {

            $schedules[$pkey]['time'] = [
                'start_time' => $time->start_time,
                'end_time'   => $time->end_time,
            ];

            foreach ($days as $day) {

                $items = $getScheduleWithTime
                    ->where('day', $day)
                    ->where('start_time', $time->start_time);

                $schedules[$pkey][$day] = $items;
            }
        }

        return $schedules;
    }

    // My Controller code

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $this->scheduleService->getWithRoleUsers($user);

        if ($user->hasRole('admin')) {
            $query = $this->scheduleService->getWithsearchFilters($request->all(), $user);
        }

        $queryResult = $this->scheduleService->getScheduleWithTime($query, $user);

        $data               = $queryResult['data'];
        $scheduleCollection = $queryResult['collection'];

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $time = $this->scheduleService->getStartTimesAndEndTimes($user);

        $schedules = $this->scheduleService->getScheduleWithTimeAndDays($scheduleCollection, $time, $days);

        // $dropdown = $this->scheduleService->getWithSelectData();
        $departments = Department::all();
        $teachers    = Teacher::select('id', 'name')->get();
        $classes     = Classroom::select('id', 'class_name')->get();
        $students    = Student::select('id', 'name')->get();
        $subjects    = Subject::all();
        return view('Schedule.index', array_merge([
            'schedules'   => $schedules,
            'time'        => $time,
            'days'        => $days,
            'data'        => $data,
            'departments' => $departments,
            'teachers'    => $teachers,
            'classes'     => $classes,
            'students'    => $students,
            'subjects'    => $subjects,
        ]));
    }

 