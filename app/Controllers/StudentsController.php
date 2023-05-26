<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentsModel;

class StudentsController extends BaseController
{
    public function index()
    {
        $fetchStudent = new StudentsModel();
        $data['students'] = $fetchStudent->findAll();
        
        return view('students/list', $data);
    }

    public function createStudent()
    {
        $data['studentNumber'] = '2023_'.uniqid();
        return view('students/add', $data);
    }
   
    public function storeStudent()
    {
        $insertStudents = new StudentsModel();

        if($img = $this->request->getFile('studentProfile')){
            if($img->isValid() && ! $img->hasMoved()){
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        $data = array(
            'stud_fullname' => $this->request->getPost('studentName'),
            'stud_id' => $this->request->getPost('studentNum'),
            'stud_section' => $this->request->getPost('studentSection'),
            'stud_course' => $this->request->getPost('studentCourse'),
            'stud_year' => $this->request->getPost('studentYear'),
            'stud_year_level' => $this->request->getPost('studentLevel'),
            'stud_profile' => $imageName,

        );

        $insertStudents->insert($data);

        return redirect()->to('/students')->with('success', 'Student Addedd Successfully!');
    }

    public function editStudent($id)
    {
        $fetchStudent = new StudentsModel();
        $data['student'] = $fetchStudent->where('id', $id)->first();

        return view('students/edit', $data);
    }

    public function updateStudent($id)
    {
        $updateStudents = new StudentsModel();
        $db = db_connect();

        if($img = $this->request->getFile('studentProfile')){
            if($img->isValid() && ! $img->hasMoved()){
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        if(!empty($_FILES['studentProfile']['name'])){
            $db->query("UPDATE tbl_students SET  stud_profile = '$imageName' WHERE id = '$id'");
        }

        $data = array(
            'stud_fullname' => $this->request->getPost('studentName'),
            'stud_id' => $this->request->getPost('studentNum'),
            'stud_section' => $this->request->getPost('studentSection'),
            'stud_course' => $this->request->getPost('studentCourse'),
            'stud_year' => $this->request->getPost('studentYear'),
            'stud_year_level' => $this->request->getPost('studentLevel'),

        );

        $updateStudents->update($id, $data);

        return redirect()->to('/students')->with('success', 'Student Updated Successfully!');
    }

    public function deleteStudent($id)
    {
        $deleteStudent = new StudentsModel();
        $deleteStudent->delete($id);

        return redirect()->to('/students')->with('success', 'Student Deletes Successfully!');
    }
}
