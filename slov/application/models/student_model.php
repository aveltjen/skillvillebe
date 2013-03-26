<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Student_model extends CI_Model
{
   ///////////////////////////////// Private
   
   private function create ($student)
   {
      $data = array();
      
      if (isset($student->ID)) { $data['id'] = $student->ID; } else { $data['id'] = -1; }
      if (isset($student->SchoolID)) { $data['schoolid'] = $student->SchoolID; } else { $data['schoolid'] = -1; }
      if (isset($student->LangID)) { $data['langid'] = $student->LangID; } else { $data['langid'] = ''; }
      if (isset($student->Firstname)) { $data['fname'] = $student->Firstname; } else { $data['fname'] = ''; }
      if (isset($student->Lastname)) { $data['lname'] = $student->Lastname; } else { $data['lname'] = ''; }
      if (isset($student->Username)) { $data['uname'] = $student->Username; } else { $data['uname'] = ''; }
      if (isset($student->Birthdate)) { $data['birthdate'] = $student->Birthdate; } else { $data['birthdate'] = 0; }
      if (isset($student->ActiveGroupEnterDate)) { $data['joindate'] = $student->ActiveGroupEnterDate; } else { $data['joindate'] = 0; }
      if (isset($student->ActiveGroupID)) { $data['groupid'] = $student->ActiveGroupID; } else { $data['groupId'] = -1; }

      return (new c\admin\Student($data));
   }
   
   private function startSelect ()
   {
      $this->db->select('student.ID, SchoolID, LangID, Firstname, Lastname, Username, Birthdate, ActiveGroupEnterDate, ActiveGroupID');
      $this->db->from('student');
      $this->db->join('login', 'login.AccountID = student.ID');
      $this->db->join('group', 'student.ActiveGroupID = group.ID');
   }
   
   private function fillArray()
   {
      $students = array();
      foreach ($this->db->get()->result() as $student) 
      {
         $students[] = $this->create($student);
      }
      return ($students);
   }
   
   ///////////////////////////////// Public Get
   
   public function getById ($id)
   {
      $this->startSelect();
      $this->db->where('ID', $id);
      $student = $this->db->get()->result();
      
      if (count($student) == 0) { return (null); }
      $student = $student[0];
      
      return ($this->create($student));
   }
   
   public function getByGroup ($group, $offset = 0, $limit = -1)
   {
      // Return an array of students for the given group.
      $this->startSelect();
      $this->db->where('ActiveGroupID', $group->groupId);
      return ($this->fillArray());
   }
   
   ///////////////////////////////// Public Set
   
   private function getData ($student)
   {
      $data = array();
      if (isset($student->userId)) { $data['ID'] = $student->userId; }
      if (isset($student->birthDate)) { $data['Birthdate'] = $student->birthDate; }
      if (isset($student->firstName)) { $data['Firstname'] = $student->firstName; }
      if (isset($student->lastName)) { $data['Lastname'] = $student->lastName; }
      return ($data);
   }

   private function getLoginData ($student)
   {
      $data = array('Type' => 2);
      if (isset($student->userName)) { $data['Username'] = $student->userName; }
      if (isset($student->password)) { $data['Password'] = getPasswordHash($student->password); }
      return ($data);
   }
   
   public function add ($student)
   {
      try
      {
         $this->db->trans_start();
         $this->db->insert('login', $this->getLoginData($student));
         $id = $this->db->insert_id();
         $student->userId = $id;
         $this->db->insert('student', $this->getData($student));
         $this->db->trans_complete();
         if (!$this->db->trans_status()) { return (false); }
         return ($id);
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   public function save ($student)
   {
      if (!isset($student->userId)) { return (false); }
      try
      {
         $this->db->trans_start();
         if (isset($student->userName))
         {
            $this->db->where('AccountID', $student->userId)
                     ->update('login', array('Username' => $student->userName));
         }
         $data = $this->getData($student);
         if (count($data) > 0)
         {
            $this->db->where('ID', $student->userId)
                     ->update('student', $data);
         }
         $this->db->trans_complete();
         return ($this->db->trans_status());
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   ///////////////////////////////// Public Delete
   
   public function remove ($id)
   {
      $this->db->trans_start();
      $this->db->where('ID', $id)->delete('student');
      $this->db->where('AccountID', $id)->delete('login');
      $this->db->where('StudentID', $id)->delete('studentgroup');
      $this->db->trans_complete();
      return ($this->db->trans_status());
   }
}

?>
