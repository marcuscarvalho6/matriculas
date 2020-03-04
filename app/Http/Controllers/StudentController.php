<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(Request $request)
    {
        return $this->studentService->getStudents($request->all());
    }

    public function store(StudentStoreRequest $request)
    {
        return $this->studentService->storeStudent($request->all());
    }

    public function show($id)
    {
        return $this->studentService->showStudent($id);
    }

    public function update(StudentUpdateRequest $request, $id)
    {
        return $this->studentService->updateStudent($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->studentService->deleteStudent($id);
    }
}
