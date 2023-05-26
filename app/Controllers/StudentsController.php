<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentsModel;

class StudentsController extends BaseController
{
    public function index()
    {
        $fetchStudent = new StudentsModel();
        $data['students'] =$fetchStudent->findAll();
        return view('students/list', $data);
    }

    public function createStudent()
    {
        $data['studentNumber'] = '30000_'.\uniqid();
        return view('students/add', $data);
    }

    public function storeStudent()
    {
        $insertStudents = new StudentsModel();

        $data = array(
            'student_name' => $this->request->getPost('studentName'),
            'student_id' => $this->request->getPost('studentNum'),
            'student_section' => $this->request->getPost('studentSection'),
            'student_course' => $this->request->getPost('studentCourse'),
            'student_batch' => $this->request->getPost('studentBatch'),
            'student_grade_level' => $this->request->getPost('studentLavel'),
        );

        $insertStudents->insert($data);

        return redirect()->to('/students')->with('success','Student Added Successfully!');

    }
    public function editStudent($id)
    {
        $fetchStudent = new StudentsModel();
        $data['student'] = $fetchStudent->where('id', $id)->first();
        
        return view('students/edit', $data);
    }
        
    public function updateStudent($id)
    {
        $updateStudent = new StudentsModel();
        $db = db_connect();
        $data = array (
            'student_name' => $this->request->getPost('studentName'),
            'student_id' => $this->request->getPost('studentNum'),
            'student_section' => $this->request->getPost('studentSection'),
            'student_course' => $this->request->getPost('studentCourse'),
            'student_batch' => $this->request->getPost('studentBatch'),
            'student_grade_level' => $this->request->getPost('studentLevel'),
        );
        $updateStudent->update($id, $data);

        return redirect()->to('/students')->with('success', 'Student Update Succesfuly!');

    } 
    public function deleteStudent($id)
    {
        //delete student
        $deleteStudent = new StudentsModel();
        $deleteStudent->delete($id);

        return redirect()->to('/students')->with('success', 'Student Delete Succesfuly!');
    
    }

}