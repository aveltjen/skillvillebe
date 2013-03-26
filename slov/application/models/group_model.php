<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Group_model extends CI_Model
{
   ///////////////////////////////// Private
   
   private function create ($group)
   {
      $data = array();
      
      if (isset($group->ID)) { $data['id'] = $group->ID; } else { $data['id'] = -1; }
      if (isset($group->SchoolID)) { $data['schoolid'] = $group->SchoolID; } else { $data['schoolid'] = -1; }
      if (isset($group->CreateDate)) { $data['createdate'] = $group->CreateDate; } else { $data['createdate'] = 0; }
      if (isset($group->Name)) { $data['name'] = $group->Name; } else { $data['name'] = ''; }
      if (isset($group->Key)) { $data['key'] = $group->Key; } else { $data['key'] = ''; }
      if (isset($group->LinkID)) { $data['packageId'] = $group->LinkID; } else { $data['packageId'] = -1; }
      if (isset($group->LinkName)) { $data['packageName'] = $group->LinkName; } else { $data['packageName'] = ''; }
      if (isset($group->CurCount)) { $data['curcount'] = $group->CurCount; } else { $data['curcount'] = -1; }
      
      return (new c\admin\Group($data));
   }
   
   private function generateKey()
   {
      $keyChar = '0123456789BCDFGHJKLMNPQRSTVWXZ';
      $key = ''; $maxLen = strlen($keyChar) - 1;
      for ($i = 0; $i < 10; $i++) { $key .= $keyChar[rand(0, $maxLen)]; }
      return ($key);
   }

   private function startSelect()
   {
      $this->db->select('group.ID, group.SchoolID, CreateDate, group.Name, Key, LinkID, package.Name as LinkName');
      $this->db->from('group');
      $this->db->join('packagelink', 'group.LinkID = packagelink.ID');
      $this->db->join('package', 'packagelink.PackageID = package.ID');
   }
   
   private function fillArray()
   {
      $groups = array();
      foreach ($this->db->get()->result() as $group) 
      {
         $groups[] = $this->create($group);
      }
      return ($groups);
   }
   
   ///////////////////////////////// Public Get
   
   public function getBySchool ($school)
   {
      // Returns all the groups in the given school.
      $this->startSelect();
      $this->db->where('group.SchoolID', $school->schoolId);
      return ($this->fillArray());
   }
   
   public function getBySchoolShort ($school)
   {
      // Returns a summery of all the groups in the given school.
      $groups = array();
      
      foreach ($this->db->get_where('group',
         array('SchoolID' => $school->schoolId))->result() as $group)
      {
         $groups[] = array($group->ID, $group->Name, $group->CreateDate);
      }
      
      return ($groups);
   }

   public function getIdListByTeacherId ($id)
   {
      // Returns all groups IDs associated with a teacher of the given ID.
      $this->startSelect();
      $this->db->join('teachergroup', 'group.ID = teachergroup.GroupID');
      $this->db->where('TeacherID', $id);
      $ids = array();
      foreach ($this->db->get()->result() as $group)  { $ids[] = $group->ID; }
      return ($ids);
   }
   
   public function getById ($id)
   {
      // Returns a group by its id:
      $this->startSelect();
      $this->db->where('group.ID', $id);
      $group = $this->db->get()->result();
      
      if (count($group) == 0) { return (null); }
      $group = $group[0];
      $group->CurCount = $this->countStudentsByGroupId($id);
      
      return ($this->create($group));
   }
   
   public function countStudentsByGroupId ($id)
   {
      // Check if a given group (ID) has associated students.
      $this->db->from('studentgroup')->where('GroupID', $id);
      return ($this->db->count_all_results());
   }
   
   ///////////////////////////////// Public Set
   
   private function getData ($group)
   {
      $data = array();
      if (isset($group->name)) { $data['Name'] = $group->name; }
      if (isset($group->createDate)) { $data['CreateDate'] = toDate($group->createDate); }
      if (isset($group->schoolId)) { $data['SchoolID'] = $group->schoolId; }
      if (isset($group->packageId)) { $data['LinkID'] = $group->packageId; }
      if (isset($group->key)) { $data['Key'] = $group->key; }
      return ($data);
   }
   
   public function add ($group)
   {
      try
      {
         $data = $this->getData($group);
         for ($tries = 499; $tries >= 0; $tries--)
         {
            $data['Key'] = $this->generateKey();
            $this->db->insert('group', $data);
            if ($this->db->affected_rows() > 0) { break; }
         }
         if ($tries < 0) { return (false); }
         return ($this->db->insert_id());
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   public function save ($group)
   {
      if (!isset($group->groupId)) { return (false); }
      try
      {
         $data = $this->getData($group);
         if (count($data) > 0)
         {
            $this->db->where('ID', $group->groupId)
                     ->update('group', $data);
         }
         return (true);
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   public function attachTeacherGroup ($groupId, $teacherId)
   {
      // Create a teacher-group association:
      $this->db->insert('teachergroup',
         array('GroupID' => $groupId, 'TeacherID' => $teacherId));
      return ($this->db->affected_rows() > 0);
   }
   
   public function attachStudentGroup ($groupId, $studentId)
   {
      // Create a student-group association:
      $this->db->insert('studentgroup',
         array('GroupID' => $groupId,
               'StudentID' => $studentId,
               'EnterDate' => date_create(time())));
      return ($this->db->affected_rows() > 0);
   }
   
   ///////////////////////////////// Public Delete
   
   public function detachTeacherGroup ($groupId, $teacherId)
   {
      // Remove a teacher-group association:
      $this->db->where('GroupID', $groupId);
      $this->db->where('TeacherID', $teacherId);
      $this->db->delete('teachergroup');
      return ($this->db->affected_rows() > 0);
   }
   
   public function detachStudentGroup ($groupId, $studentId)
   {
      // Remove a student-group association:
      $this->db->where('GroupID', $groupId);
      $this->db->where('StudentID', $studentId);
      $this->db->delete('studentgroup');
      return ($this->db->affected_rows() > 0);
   }
   
   public function remove ($id)
   {
      $this->db->trans_start();
      $this->db->where('ID', $id)->delete('group');
      $this->db->where('GroupID', $id)->delete('teachergroup');
      $this->db->where('GroupID', $id)->delete('studentgroup');
      $this->db->trans_complete();
      return ($this->db->trans_status());
   }
}

?>