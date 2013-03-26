<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Admin_model extends CI_Model
{
   ///////////////////////////////// Private
   
   private function create ($admin)
   {
      $data = array();
      
      if (isset($admin->ID)) { $data['id'] = $admin->ID; } else { $data['id'] = -1; }
      if (isset($admin->SchoolID)) { $data['schoolid'] = $admin->SchoolID; } else { $data['schoolid'] = -1; }
      if (isset($admin->LangID)) { $data['langid'] = $admin->LangID; } else { $data['langid'] = ''; }
      if (isset($admin->Firstname)) { $data['fname'] = $admin->Firstname; } else { $data['fname'] = ''; }
      if (isset($admin->Lastname)) { $data['lname'] = $admin->Lastname; } else { $data['lname'] = ''; }
      if (isset($admin->Username)) { $data['uname'] = $admin->Username; } else { $data['uname'] = ''; }

      return (new c\admin\Admin($data));
   }
   
   private function startSelect ()
   {
      $this->db->select('admin.ID, SchoolID, LangID, Firstname, Lastname, Username');
      $this->db->from('admin');
      $this->db->join('login', 'login.AccountID = admin.ID');
   }
   
   ///////////////////////////////// Public Get
   
   public function getById ($id)
   {
      $this->startSelect();
      $this->db->where('ID', $id);
      $admin = $this->db->get()->result();
      
      if (count($admin) == 0) { return (null); }
      $admin = $admin[0];
      
      return ($this->create($admin));
   }

   ///////////////////////////////// Public Set
   
   private function getData ($admin)
   {
      $data = array();
      if (isset($admin->userId)) { $data['ID'] = $admin->userId; }
      if (isset($admin->schoolId)) { $data['SchoolID'] = $admin->schoolId; }
      if (isset($admin->firstName)) { $data['Firstname'] = $admin->firstName; }
      if (isset($admin->lastName)) { $data['Lastname'] = $admin->lastName; }
      return ($data);
   }

   private function getLoginData ($admin)
   {
      $data = array('Type' => 0);
      if (isset($admin->userName)) { $data['Username'] = $admin->userName; }
      if (isset($admin->password)) { $data['Password'] = getPasswordHash($admin->password); }
      return ($data);
   }
   
   public function add ($admin)
   {
      try
      {
         $this->db->trans_start();
         $this->db->insert('login', $this->getLoginData($admin));
         $id = $this->db->insert_id();
         $admin->userId = $id;
         $this->db->insert('admin', $this->getData($admin));
         $this->db->trans_complete();
         if (!$this->db->trans_status()) { return (false); }
         return ($id);
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   public function save ($admin)
   {
      if (!isset($admin->userId)) { return (false); }
      try
      {
         $this->db->trans_start();
         if (isset($admin->userName))
         {
            $this->db->where('AccountID', $admin->userId)
                     ->update('login', array('Username' => $admin->userName));
         }
         $data = $this->getData($admin);
         if (count($data) > 0)
         {
            $this->db->where('ID', $admin->userId)
                     ->update('admin', $data);
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
      $this->db->where('ID', $id)->delete('admin');
      $this->db->where('AccountID', $id)->delete('login');
      $this->db->trans_complete();
      return ($this->db->trans_status());
   }
}

?>
