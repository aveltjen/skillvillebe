<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class School_model extends CI_Model
{
   ///////////////////////////////// Private
   
   private function create ($school)
   {
      $data = array();
      
      if (isset($school->ID)) { $data['id'] = $school->ID; } else { $data['id'] = -1; }
      if (isset($school->Name)) { $data['name'] = $school->Name; } else { $data['name'] = ''; }
      if (isset($school->Address)) { $data['address'] = $school->Address; } else { $data['address'] = ''; }
      if (isset($school->Postcode)) { $data['postcode'] = $school->Postcode; } else { $data['postcode'] = ''; }
      if (isset($school->City)) { $data['city'] = $school->City; } else { $data['city'] = ''; }
      
      return (new c\admin\School($data));
   }
   
   ///////////////////////////////// Public Get
   
   public function getByUser ($user)
   {
      // Given the user, get the school objcet associated with the user:
      
      $school = $this->db->get_where('school',
         array('ID' => $user->schoolId))->result();
         
      if (count($school) <= 0) { return (false); }
      $school = $school[0];
      
      return ($this->create($school));
   }

   ///////////////////////////////// Public Set
   
   private function getData ($school)
   {
      $data = array();
      if (isset($school->name)) { $data['Name'] = $school->name; }
      if (isset($school->address)) { $data['Address'] = $school->address; }
      if (isset($school->postCode)) { $data['Postcode'] = $school->postCode; }
      if (isset($school->city)) { $data['City'] = $school->city; }
      return ($data);
   }
   
   public function add ($school)
   {
      try
      {
         $data = $this->getData($school);
         if (count($data) == 0) { return (false); }
         $this->db->insert('school', $data);
         if ($this->db->affected_rows() == 0) { return (false); }
         return ($this->db->insert_id());
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   public function save ($school)
   {
      if (!isset($school->schoolId)) { return (false); }
      try
      {
         $data = $this->getData($school);
         if (count($data) > 0)
         {
            $this->db->where('ID', $school->schoolId)
                     ->update('school', $data);
         }
         return (true);
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   ///////////////////////////////// Public Delete
   
   public function remove ($id)
   {
      $this->db->where('ID', $id);
      $this->db->delete('school');
      return ($this->db->affected_rows() > 0);
   }
}

?>
