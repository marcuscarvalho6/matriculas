<?php

namespace App\Services;

use App\Entities\Course;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseService
{
    private $courseModel;

    public function __construct(Course $courseModel)
    {
        $this->courseModel = $courseModel;
    }

    public function getCourses($filters = [])
    {
        $query = $this->courseModel;
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'title') {
            $query = $query->orderBy('title', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-title') {
            $query = $query->orderBy('title', 'desc');
        }
        if(isset($filters['search']) && !empty($filters['search'])) {
            $query = $query->where(function($q) use ($filters) {
                $q->where('title','like', "%{$filters['search']}%");
                $q->orWhere('description','like', "%{$filters['search']}%");
            });
        }
        return $query->paginate(20);
    }

    public function storeCourse($fields)
    {
        return $this->courseModel->create([
            'title' => $fields['title'],
            'description' => $fields['description']
        ]);
    }

    public function updateCourse($id, $fields)
    {
        return $this->courseModel->where('id', $id)
            ->updateOrCreate(['id' => $id], [
                'title' => $fields['title'],
                'description' => $fields['description']
        ]);
    }

    public function showCourse($id)
    {
        $course = $this->courseModel->find($id);
        if(!$course) {
            abort(404, "Curso não encontrado");
        }
        return $course;
    }

    public function deleteCourse($id)
    {
        $course = $this->courseModel->find($id);
        if(!$course) {
            abort(404, "Curso não encontrado");
        }
        return $course->delete();
    }
}