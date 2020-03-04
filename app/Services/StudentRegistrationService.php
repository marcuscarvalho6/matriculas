<?php

namespace App\Services;

use App\Entities\StudentRegistration;
use Exception;
use PHPUnit\Framework\Constraint\FileExists;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentRegistrationService
{
    private $studentRegistrationModel;

    public function __construct(StudentRegistration $studentRegistrationModel)
    {
        $this->studentRegistrationModel = $studentRegistrationModel;
    }

    public function getStudentRegistrations($filters = [])
    {
        $query = $this->studentRegistrationModel->select(
            'student_registrations.id',
            'students.name',
            'students.email',
            'students.date_of_birth',
            'students.gender',
            'courses.title',
            'courses.description',
            'student_registrations.created_at',
            'student_registrations.updated_at'
        )
            ->join('students', 'student_registrations.student_id', '=', 'students.id')
            ->join('courses', 'student_registrations.course_id', '=', 'courses.id');
        // Order by course title
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'title') {
            $query = $query->orderBy('courses.title', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-title') {
            $query = $query->orderBy('courses.title', 'desc');
        }
        // Order by student name
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'name') {
            $query = $query->orderBy('students.name', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-name') {
            $query = $query->orderBy('students.name', 'desc');
        }
        // Order by student email
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'email') {
            $query = $query->orderBy('students.email', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-email') {
            $query = $query->orderBy('students.email', 'desc');
        }
        // Order by student registration age
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'age') {
            $query = $query->orderBy('students.date_of_birth', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-age') {
            $query = $query->orderBy('students.date_of_birth', 'desc');
        }
        // Order by student registration id
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'id') {
            $query = $query->orderBy('student_registrations.id', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-id') {
            $query = $query->orderBy('student_registrations.id', 'desc');
        }
        // Search student registration by student email or name
        if(isset($filters['search']) && !empty($filters['search'])) {
            $query = $query->where(function($q) use ($filters) {
                $q->where('students.name','like', "%{$filters['search']}%");
                $q->orWhere('students.email','like', "%{$filters['search']}%");
            });
        }
        return $query->paginate(20);
    }

    public function storeStudentRegistration($fields)
    {
        $studentRegistration = $this->studentRegistrationModel->where('student_id', $fields['student_id'])
            ->where('course_id', $fields['course_id'])
            ->first();

        if($studentRegistration) {
            abort(422, "Aluno já registrado no curso");
        }
        return $this->studentRegistrationModel->create([
            'student_id' => $fields['student_id'],
            'course_id' => $fields['course_id']
        ]);
    }

    public function updateStudentRegistration($id, $fields)
    {
        $studentRegistration = $this->studentRegistrationModel->where('student_id', $fields['student_id'])
            ->where('course_id', $fields['course_id'])
            ->first();
        if($studentRegistration) {
            return $this->showStudentRegistration($id);
        }
        $this->studentRegistrationModel->where('id', $id)
            ->update([
                'student_id' => $fields['student_id'],
                'course_id' => $fields['course_id']
            ]);
        return $this->showStudentRegistration($id);
    }

    public function showStudentRegistration($id)
    {
        $studentRegistration = $this->studentRegistrationModel->select(
            'student_registrations.id',
            'students.name',
            'students.email',
            'students.date_of_birth',
            'students.gender',
            'courses.title',
            'courses.description',
            'student_registrations.created_at',
            'student_registrations.updated_at'
        )
            ->join('students', 'student_registrations.student_id', '=', 'students.id')
            ->join('courses', 'student_registrations.course_id', '=', 'courses.id')
            ->find($id);
        if(!$studentRegistration) {
            abort(404, "Matrícula não encontrada");
        }
        return $studentRegistration;
    }

    public function deleteStudentRegistration($id)
    {
        $course = $this->studentRegistrationModel->find($id);
        if(!$course) {
            abort(404, "Matrícula não encontrada");
        }
        return $course->delete();
    }

    public function getStatistics($filters = [])
    {
        $studentRegistrations = $this->studentRegistrationModel->selectRaw("
            student_registrations.student_id,
            student_registrations.course_id,
            courses.title as course,
            SUM(CASE WHEN students.gender = 'M' THEN 1 ELSE 0 END) as total_male,
            SUM(CASE WHEN students.gender = 'F' THEN 1 ELSE 0 END) as total_female,
            SUM(CASE WHEN TIMESTAMPDIFF(year, date_of_birth, now()) < 15 THEN 1 ELSE 0 END) as age_below_15,
            SUM(CASE WHEN TIMESTAMPDIFF(year, date_of_birth, now()) >= 15 AND TIMESTAMPDIFF(year, date_of_birth, now()) < 19 THEN 1 ELSE 0 END) as age_15_18,
            SUM(CASE WHEN TIMESTAMPDIFF(year, date_of_birth, now()) >= 19 AND TIMESTAMPDIFF(year, date_of_birth, now()) < 25 THEN 1 ELSE 0 END) as age_19_24,
            SUM(CASE WHEN TIMESTAMPDIFF(year, date_of_birth, now()) >= 25 AND TIMESTAMPDIFF(year, date_of_birth, now()) < 31 THEN 1 ELSE 0 END) as age_25_30,
            SUM(CASE WHEN TIMESTAMPDIFF(year, date_of_birth, now()) > 30 THEN 1 ELSE 0 END) as age_above_30
        ")
            ->join('students', 'student_registrations.student_id', '=', 'students.id')
            ->join('courses', 'student_registrations.course_id', '=', 'courses.id')
            ->groupBy('courses.id')
            ->groupBy('gender')
            ->with(['students'])
            ->get();
        return $studentRegistrations;
    }
}