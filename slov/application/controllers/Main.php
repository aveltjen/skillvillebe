<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Main extends CI_Controller
{
   public function index()
   {
      $this->load->model('user_model');
      $user = getCurrentUser($this);
      
      $strtab = getStringTable($this);
      $strtab->loadSet('common');
      
      $data = array();
      $data['strtab'] = $strtab;
      
      // Check if the user is logged in:
      if ($user)
      {
         // Load the dashboard for the current user:
         $data['user'] = $user;
         $strtab->loadSet('dashboard');
         $this->load->view('main/dashboard_view', $data);
      }
      else
      {
         // Not logged in: show the login:
         $data['prevLogin'] = false;
         $strtab->loadSet('login');
         $this->load->view('main/login_view', $data);
      }
   }
   
   public function lang($langId)
   {
      // Change the language to the given language id:
      $this->load->model('user_model');
      $this->session->set_userdata('lang', $langId);
      
      $user = getCurrentUser($this);
      if ($user) { $this->user_model->setLangId($user->userId, $langId); }
      
      $nav = $this->input->post('nav');
      if (!$nav) { $this->index(); } // Reload index page by default.
      else
      {
         // Otherwise navigate to the specified page:
         redirect($nav, 'location');
      }
   }
   
   public function login()
   {
      // Attempt to login with posted credentials:
      $this->load->model('user_model');
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $user = $this->user_model->login($username, $password);
      if ($user)
      {
         // Good; continue to dashboard:
         redirect(base_url('index.php/main'), 'location');
      }
      else
      {
         $strtab = getStringTable($this);
         $strtab->loadSet('common');
         $strtab->loadSet('login');
         
         // Fail; re-login:
         $data = array();
         $data['prevLogin'] = true;
         $data['username'] = $username;
         $data['password'] = $password;
         $data['strtab'] = $strtab;
         $this->load->view('main/login_view', $data);
      }
   }
   
   public function logout()
   {
      // Clear previous user session data and re-login:
      $this->load->model('user_model');
      $this->user_model->logout();
      redirect(base_url('index.php/main'), 'location');
   }
   
   /// Debug features:
   
   public function cheatcode_sneakysecretadd($username, $pass, $type)
   {
      // !! Cheatcode: use this to add a new user to the database. !!
      $user = new stdClass;
      $user->userName = $username;
      $user->password = $pass;
      $user->schoolId = 1;
      $user->firstName = 'Cheater';
      $user->lastName = 'Cheatson';
      if ($type == 0)
      {
         $this->load->model('admin_model');
         $this->admin_model->add($user);
      }
      else if ($type == 1)
      {
         $this->load->model('student_model');
         $this->student_model->add($user);
      }
      else
      {
         $this->load->model('teacher_model');
         $this->teacher_model->add($user);
      }
      exit('Awesomeness.');
   }
}

?>