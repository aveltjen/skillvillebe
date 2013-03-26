<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class User_model extends CI_Model
{
   public function login($username, $password)
   {
      // Verify user credentials (use sha256 for password):
      $query = $this->db->get_where('login',
         array('Username' => $username,
               'Password' => getPasswordHash($password)))->row_array();

      // Check if user credentials are good:
      if (count($query) <= 0) { return (false); }
      
      // Do the rest of the login:
      return ($this->loginById($query['AccountID'], $query['Type']));
   }

   public function loginById($id, $type)
   {
      $ci =& get_instance();
      
      // Load the correct user object based on account type:
      switch ($type)
      {
         case 0:
            $ci->load->model('admin_model');
            $user = $ci->admin_model->getById($id);
            break;
            
         case 1:
            $ci->load->model('student_model');
            $user = $ci->student_model->getById($id);
            break;
            
         case 2:
            $ci->load->model('teacher_model');
            $user = $ci->teacher_model->getById($id);
            break;
            
         default: return (false);
      }
      
      $this->session->set_userdata('user', serialize($user));
      $this->session->set_userdata('lang', $user->langId);
      return ($user);
   }

   public function logout()
   {
      // Clear the session cache to logout:
      $this->session->sess_destroy();
   }
   
   public function setPassword($id, $password)
   {
      // Change the password of the given user:
      $hash = getPasswordHash($password);
      $this->db->where('AccountID', $id)->update('login', array('Password' => $hash));
      
      // Verify for great justice:
      $query = $this->db->from('login')->where('AccountID', $id)->get()->result();
      if (count($query) == 0) { return (false); }
      
      return ($query[0]->Password == $hash);
   }
   
   public function setLangId($id, $langId)
   {
      // Change the language ID of the given user:
      $this->db->where('AccountID', $id)->update('login', array('LangID' => $langId));
   }
}

?>
