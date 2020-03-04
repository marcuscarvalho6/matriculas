<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRegistrationStoreRequest;
use Illuminate\Http\Request;
use App\Services\StudentRegistrationService;

class StudentRegistrationController extends Controller
{
    private $studentRegistrationService;

    public function __construct(StudentRegistrationService $studentRegistrationService)
    {
        $this->studentRegistrationService = $studentRegistrationService;
    }

    public function index(Request $request)
    {
        return $this->studentRegistrationService->getStudentRegistrations($request->all());
    }

    public function store(StudentRegistrationStoreRequest $request)
    {
        return $this->studentRegistrationService->storeStudentRegistration($request->all());
    }

    public function show($id)
    {
        return $this->studentRegistrationService->showStudentRegistration($id);
    }

    public function update(Request $request, $id)
    {
        return $this->studentRegistrationService->updateStudentRegistration($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->studentRegistrationService->deleteStudentRegistration($id);
    }

    public function statistics(Request $request)
    {
        return $this->studentRegistrationService->getStatistics($request->all());
    }
}
