<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Teacher_model extends CI_Model
{
   ///////////////////////////////// Private
   
   private function create ($teacher)
   {
      $data = array();
      
      if (isset($teacher->ID)) { $data['id'] = $teacher->ID; } else { $data['id'] = -1; }
      if (isset($teacher->SchoolID)) { $data['schoolid'] = $teacher->SchoolID; } else { $data['schoolid'] = -1; }
      if (isset($teacher->LangID)) { $data['langid'] = $teacher->LangID; } else { $data['langid'] = ''; }
      if (isset($teacher->Firstname)) { $data['fname'] = $teacher->Firstname; } else { $data['fname'] = ''; }
      if (isset($teacher->Lastname)) { $data['lname'] = $teacher->Lastname; } else { $data['lname'] = ''; }
      if (isset($teacher->Username)) { $data['uname'] = $teacher->Username; } else { $data['uname'] = ''; }

      return (new c\admin\Teacher($data));
   }
   
   private function startSelect ()
   {
      $this->db->select('teacher.ID, SchoolID, LangID, Firstname, Lastname, Username');
      $this->db->from('teacher');
      $this->db->join('login', 'login.AccountID = teacher.ID');
   }
   
   ///////////////////////////////// Public Get
   
   public function getBySchool ($school)
   {
      // Returns all teachers in the given school.
      $teachers = array();

      $this->startSelect();
      $this->db->where('SchoolID', $school->schoolId);
      
      foreach ($this->db->get()->result() as $teacher)
      {
         $teachers[] = $this->create($teacher);
      }
      
      return ($teachers);
   }
   
   public function getBySchoolShort ($school)
   {
      // Returns all teachers in the given school in short form.
      $teachers = array();

      foreach ($this->db->get_where('teacher',
         array('SchoolID' => $school->schoolId))->result() as $teacher)
      {
         $teachers[] = array($teacher->ID, $teacher->Firstname, $teacher->Lastname);
      }
      
      return ($teachers);
   }
   
   public function getById ($id)
   {
      $this->startSelect();
      $this->db->where('ID', $id);
      $teacher = $this->db->get()->result();
      
      if (count($teacher) == 0) { return (null); }
      $teacher = $teacher[0];
      
      return ($this->create($teacher));
   }
   

   ///////////////////////////////// Public Set
   
   private function getData ($teacher)
   {
      $data = array();
      if (isset($teacher->userId)) { $data['ID'] = $teacher->userId; }
      if (isset($teacher->schoolId)) { $data['SchoolID'] = $teacher->schoolId; }
      if (isset($teacher->firstName)) { $data['Firstname'] = $teacher->firstName; }
      if (isset($teacher->lastName)) { $data['Lastname'] = $teacher->lastName; }
      return ($data);
   }

   private function getLoginData ($teacher)
   {
      $data = array('Type' => 2);
      if (isset($teacher->userName)) { $data['Username'] = $teacher->userName; }
      if (isset($teacher->password)) { $data['Password'] = getPasswordHash($teacher->password); }
      return ($data);
   }
   
   public function add ($teacher)
   {
      try
      {
         $this->db->trans_start();
         $this->db->insert('login', $this->getLoginData($teacher));
         $id = $this->db->insert_id();
         $teacher->userId = $id;
         $this->db->insert('teacher', $this->getData($teacher));
         $this->db->trans_complete();
         if (!$this->db->trans_status()) { return (false); }
         return ($id);
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   public function save ($teacher)
   {
      if (!isset($teacher->userId)) { return (false); }
      try
      {
         $this->db->trans_start();
         if (isset($teacher->userName))
         {
            $this->db->where('AccountID', $teacher->userId)
                     ->update('login', array('Username' => $teacher->userName));
         }
         $data = $this->getData($teacher);
         if (count($data) > 0)
         {
            $this->db->where('ID', $teacher->userId)
                     ->update('teacher', $data);
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
      $this->db->where('ID', $id)->delete('teacher');
      $this->db->where('AccountID', $id)->delete('login');
      $this->db->where('TeacherID', $id)->delete('teachergroup');
      $this->db->trans_complete();
      return ($this->db->trans_status());
   }

}

?>
