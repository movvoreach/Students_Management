<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Services\EnrollmentService;

class EnrollmentController extends Controller
{
    protected $enrollmentService;

    public function __construct()
    {
        $this->enrollmentService = new EnrollmentService();
    }

    public function store(StoreEnrollmentRequest $request)
    {
        $this->enrollmentService->enrollStudent($request->validated());

        return redirect()->back()->with('success', 'Student enrolled successfully');
    }
}
