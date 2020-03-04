<?php

namespace App\Services;

use App\Entities\Student;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StudentService
{
    private $studentModel;

    public function __construct(Student $studentModel)
    {
        $this->studentModel = $studentModel;
    }

    public function getStudents($filters = [])
    {
        $query = $this->studentModel;
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'name') {
            $query = $query->orderBy('name', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-name') {
            $query = $query->orderBy('name', 'desc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'email') {
            $query = $query->orderBy('email', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-email') {
            $query = $query->orderBy('email', 'desc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'age') {
            $query = $query->orderBy('date_of_birth', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-age') {
            $query = $query->orderBy('date_of_birth', 'desc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == 'id') {
            $query = $query->orderBy('id', 'asc');
        }
        if(isset($filters['orderBy']) && $filters['orderBy'] == '-id') {
            $query = $query->orderBy('id', 'desc');
        }
        if(isset($filters['search']) && !empty($filters['search'])) {
            $query = $query->where(function($q) use ($filters) {
                $q->where('name','like', "%{$filters['search']}%");
                $q->orWhere('email','like', "%{$filters['search']}%");
            });
        }
        return $query->paginate(20);
    }

    public function storeStudent($fields)
    {
        $dateOfBirth = explode('/',$fields['date_of_birth']);
        $dateOfBirth = "{$dateOfBirth[2]}/$dateOfBirth[1]/$dateOfBirth[0]}";
        return $this->studentModel->create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'date_of_birth' => $dateOfBirth,
            'gender' => $fields['gender']
        ]);
    }

    public function updateStudent($id, $fields)
    {
        $dateOfBirth = explode('/',$fields['date_of_birth']);
        $dateOfBirth = "{$dateOfBirth[2]}/$dateOfBirth[1]/$dateOfBirth[0]}";
        return $this->studentModel->where('id', $id)
            ->updateOrCreate(['id' => $id], [
                'name' => $fields['name'],
                'email' => $fields['email'],
                'date_of_birth' => $dateOfBirth,
                'gender' => $fields['gender']
        ]);
    }

    public function showStudent($id)
    {
        $student = $this->studentModel->find($id);
        if(!$student) {
            throw new NotFoundHttpException();
        }
        return $student;
    }

    public function deleteStudent($id)
    {
        $student = $this->studentModel->find($id);
        if(!$student) {
            throw new NotFoundHttpException();
        }
        return $student->delete();
    }
}