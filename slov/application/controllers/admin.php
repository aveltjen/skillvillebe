<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Admin extends CI_Controller
{
   public function index() { }
   
   private function checkUser()
   {
      // Load logged in user (only admins can use this controller):
      $user = getCurrentUser($this);
      if (!is_a($user, 'c\admin\Admin'))
      {
         $this->output->set_status_header(401);
         exit('Not authorised or not logged in.');
      }
      return ($user);
   }
   
   private function safetyCheck()
   {
      // Should use this for all operations with side-effects.
      // Safety check [forces the post method to prevent proxy trouble or accidental triggering]:
      if (strcmp($this->input->post('really_do_this'), 'Yes, I am actually serious.'))
      {
         $this->output->set_status_header(401);
         exit();
      }
   }
   
   private function reloadIfUser($user1, $user2)
   {
      if (isset($user1->userId) && isset($user2->userId) &&
          $user1->userId == $user2->userId)
      {
         $this->load->model('user_model');
         $this->user_model->loginById($user1->userId, getUserTypeCode($user1));
      }
   }
   
   // Info-related functions:
   
   // Get info about teachers and all groups:
   public function get_teacher_dashboard()
   {
      $user = $this->checkUser();
      
      $this->load->model('teacher_model');
      $this->load->model('group_model');
      
      $data['teachers'] = $this->teacher_model->getBySchoolShort($user);
      $data['groups'] = $this->group_model->getBySchool($user);
      
      // Show the info:
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($data));
   }
   
   // Get info about groups only:
   public function get_group_dashboard()
   {
      $user = $this->checkUser();
      
      $this->load->model('group_model');
      $data['groups'] = $this->group_model->getBySchoolShort($user);
      
      // Show the info:
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($data));
   }
   
   // Get detailed info about a teacher.
   public function get_teacher($id)
   {
      $user = $this->checkUser();
      
      $this->load->model('teacher_model');
      $this->load->model('group_model');
      
      $data['teacher'] = $this->teacher_model->getById($id);
      $data['groups'] = $this->group_model->getIdListByTeacherId($id);
      
      // Show the info:
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($data));
   }
   
   // Get detailed info about a group.
   public function get_group($id)
   {
      $user = $this->checkUser();
      
      $this->load->model('group_model');
      $data['group'] = $this->group_model->getById($id);
      
      // Show the info:
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($data));
   }
   
   public function get_students_by_group($id, $offset, $limit)
   {
      $user = $this->checkUser();
      
      $group = new stdClass();
      $group->id = $id;
      
      $this->load->model('student_model');
      $data['students'] = $this->student_model->getByGroup($group, $offset, $limit);
      
      // Show the info:
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($data));
   }
   
   // Creation of records:
   
   // Create a teacher-group association.
   public function attach_teacher_group($groupId, $teacherId)
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $this->load->model('group_model');
      
      if (!$this->group_model->attachTeacherGroup($groupId, $teacherId))
      {
         $this->output->set_status_header(500);
      }
   }
   
   // Create a teacher:
   public function add_teacher()
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $teacher = arrayToObject($this->input->post('teacher'));
      $this->load->model('teacher_model');
      
      // Add school ID:
      $teacher->schoolId = $user->schoolId;
      
      // Try to create the teacher:
      $teacher->userId = $this->teacher_model->add($teacher);
      if (!$teacher->userId)
      {
         $this->output->set_status_header(500);
         return;
      }
      
      // Send teacher data back:
      $teacher = array('id' => $teacher->userId,
                       'firstName' => $teacher->firstName,
                       'lastName' => $teacher->lastName);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($teacher));
   }
   
   // Create a group:
   public function add_group()
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $group = arrayToObject($this->input->post('group'));
      $this->load->model('group_model');
      
      // Add school ID:
      $group->schoolId = $user->schoolId;
      
      // Try to create the group:
      $group->groupId = $this->group_model->add($group);
      if (!$group->groupId)
      {
         $this->output->set_status_header(500);
         return;
      }
      
      // Send group data back:
      $group = array('id' => $group->groupId,
                     'name' => $group->name,
                     'createDate' => $group->createDate);
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($group));
   }
   
   // Modification of records:
   
   // Modify an existing teacher:
   public function save_teacher()
   {
      $user = $this->checkUser();
      $teacher = arrayToObject($this->input->post('teacher'));
      if (!isset($teacher->userId))
      {
         $this->output->set_status_header(401);
         return;
      }
      
      if ($user->userId != $teacher->userId)
      {
         $this->safetyCheck(); // Only admin can change another teacher account.
      }
      
      $this->load->model('teacher_model');
      
      if (!$this->teacher_model->save($teacher))
      {
         $this->output->set_status_header(500);
      }
      $this->reloadIfUser($user, $teacher);
   }
   
   // Modify an existing admin:
   public function save_admin()
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $admin = arrayToObject($this->input->post('admin'));
      if (!isset($admin->userId))
      {
         $this->output->set_status_header(401);
         return;
      }
      
      $this->load->model('admin_model');
      
      if (!$this->admin_model->save($admin))
      {
         $this->output->set_status_header(500);
      }
      $this->reloadIfUser($user, $admin);
   }
   
   // Modify an existing school:
   public function save_school()
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $school = arrayToObject($this->input->post('school'));
      if (!isset($school->schoolId))
      {
         $this->output->set_status_header(401);
         return;
      }
      
      $this->load->model('school_model');
      
      if (!$this->school_model->save($school))
      {
         $this->output->set_status_header(500);
      }
   }
   
   // Modify an existing group:
   public function save_group()
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $group = arrayToObject($this->input->post('group'));
      if (!isset($group->groupId))
      {
         $this->output->set_status_header(401);
         return;
      }
      
      $this->load->model('group_model');
      
      if (!$this->group_model->save($group))
      {
         $this->output->set_status_header(500);
      }
   }
   
   // Changes the password of a user:
   public function change_password()
   {
      $user = getCurrentUser($this);
      $this->safetyCheck();
      
      $this->load->model('user_model');
      
      $id = $this->input->post('id');
      $password = $this->input->post('password');
      
      if ($id)
      {
         if (!is_a($user, 'c\admin\Admin'))
         {
            $this->output->set_status_header(401);
            exit('Not authorised or not logged in.');
         }
      }
      else
      {
         $id = $user->userId;
      }
      
      if (!$this->user_model->setPassword($id, $password))
      {
         $this->output->set_status_header(500);
      }
   }
   
   
   // Deletion of records:
   
   // Remove a teacher-group association.
   public function detach_teacher_group($groupId, $teacherId)
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $this->load->model('group_model');
      
      if (!$this->group_model->detachTeacherGroup($groupId, $teacherId))
      {
         $this->output->set_status_header(500);
      }
   }

   // Remove a teacher from the system.
   public function remove_teacher()
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $teacherId = $this->input->post('id');
      $this->load->model('teacher_model');
      
      if (!$this->teacher_model->remove($teacherId))
      {
         $this->output->set_status_header(500);
      }
   }
   
   // Remove a group from the system.
   public function remove_group()
   {
      $user = $this->checkUser();
      $this->safetyCheck();
      
      $groupId = $this->input->post('id');
      $this->load->model('group_model');
      
      if ($this->group_model->countStudentsByGroupId($groupId) > 0)
      {
         $this->output->set_status_header(401);
         $this->output->set_output('Group contains students and cannot be removed.');
         return;
      }
      
      if (!$this->group_model->remove($groupId))
      {
         $this->output->set_status_header(500);
      }
   }
}

?>