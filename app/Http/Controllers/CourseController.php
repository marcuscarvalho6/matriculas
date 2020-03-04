<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use Illuminate\Http\Request;
use App\Services\CourseService;

class CourseController extends Controller
{
    private $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        return $this->courseService->getCourses($request->all());
    }

    public function store(CourseStoreRequest $request)
    {
        return $this->courseService->storeCourse($request->all());
    }

    public function show($id)
    {
        return $this->courseService->showCourse($id);
    }

    public function update(CourseUpdateRequest $request, $id)
    {
        return $this->courseService->updateCourse($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->courseService->deleteCourse($id);
    }
}
