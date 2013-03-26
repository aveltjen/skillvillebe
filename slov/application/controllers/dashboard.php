<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Dashboard extends CI_Controller
{
   public function index() { }
   
   // Admin-related dashboard functions:
   
   public function admin_overview()
   {
      // Load logged in user (must be admin):
      $user = getCurrentUser($this);
      if (!is_a($user, 'c\admin\Admin')) { return; }
      
      $this->load->model('school_model');
      $this->load->model('package_model');
      
      $data['user'] = $user;
      $data['school'] = $this->school_model->getByUser($user);
      $data['packages'] = $this->package_model->getBySchool($data['school']);
      
      // Show the overview info:
      $strtab = getStringTable($this);
      $strtab->loadSet('common');
      $strtab->loadSet('dashboard');
      $data['strtab'] = $strtab;
      $this->load->view('admin/overview_view', $data);
   }
   
   public function admin_manage_groups()
   {
      // Load logged in user (must be admin):
      $user = getCurrentUser($this);
      if (!is_a($user, 'c\admin\Admin')) { return; }
      
      $this->load->model('group_model');
      $this->load->model('package_model');
      
      // Get a list of all groups associated with the school:
      $data['user'] = $user;
      $data['groups'] = $this->group_model->getBySchool($user);
      $data['packages'] = $this->package_model->getBySchool($user);
      
      // Show the group info:
      $strtab = getStringTable($this);
      $strtab->loadSet('common');
      $strtab->loadSet('dashboard');
      $data['strtab'] = $strtab;
      $this->load->view('admin/manage_groups_view', $data);
   }
   
   public function admin_manage_teachers()
   {
      // Load logged in user (must be admin):
      $user = getCurrentUser($this);
      if (!is_a($user, 'c\admin\Admin')) { return; }
      
      $this->load->model('teacher_model');
      $this->load->model('group_model');
      
      // Get a list of all teachers in the current school:
      $data['user'] = $user;
      $data['teachers'] = $this->teacher_model->getBySchool($user);
      $data['groups'] = $this->group_model->getBySchool($user);
      
      // Show the teacher info:
      $strtab = getStringTable($this);
      $strtab->loadSet('common');
      $strtab->loadSet('dashboard');
      $data['strtab'] = $strtab;
      $this->load->view('admin/manage_teachers_view', $data);
   }
}

?>