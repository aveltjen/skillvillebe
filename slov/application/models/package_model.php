<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Package_model extends CI_Model
{
   ///////////////////////////////// Private
   
   private function create ($package)
   {
      $data = array();
         
      // The package link table contains:
      if (isset($package->ID)) { $data['id'] = $package->ID; } else { $data['id'] = -1; }
      if (isset($package->StudentCount)) { $data['maxcount'] = $package->StudentCount; } else { $data['maxcount'] = 0; }
      if (isset($package->Name)) { $data['name'] = $package->Name; } else { $data['name'] = ''; }
      $data['curcount'] = $this->countStudentsByPackageId($data['id']);
      
      // Find the current student count:
      $data['curcount'] = 0;
      
      return (new c\admin\Package($data));
   }
   
   private function startSelect ()
   {
      $this->db->select('packagelink.ID as ID, StudentCount, Name');
      $this->db->from('packagelink');
      $this->db->join('package', 'packagelink.PackageID = package.ID');
   }
   
   ///////////////////////////////// Public Get
   
   public function getBySchool ($school)
   {
      // Given a school, get an array of packages associated with that school.
      $packages = array();
      
      // Load the package data from the db:
      $this->startSelect();
      $this->db->where('SchoolID', $school->schoolId);

      foreach ($this->db->get()->result() as $package) 
      {
         $packages[] = $this->create($package);
      }
      
      return ($packages);
   }

   public function getById ($id)
   {
      // Load the package data from the db:
      $this->startSelect();
      $this->db->where('packagelink.ID', $id);
      $package = $this->db->get()->result();
      
      if (count($package) == 0) { return (null); }
      $package = $package[0];
      
      return ($this->create($package));
   }

   public function countStudentsByPackageId ($id)
   {
      // Check all students currently using a package:
      $this->db->from('student')
               ->join('group', 'student.ActiveGroupID = group.ID')
               ->where('LinkID', $id);
      return ($this->db->count_all_results());
   }

   ///////////////////////////////// Public Set
   
   private function getData ($package)
   {
      $data = array();
      if (isset($package->name)) { $data['Name'] = $package->name; }
      if (isset($package->maxCount)) { $data['StudentCount'] = $package->maxCount; }
      return ($data);
   }
   
   public function add ($package)
   {
      try
      {
         $data = $this->getData($package);
         if (count($data) == 0) { return (false); }
         $this->db->insert('package', $data);
         if ($this->db->affected_rows() == 0) { return (false); }
         return ($this->db->insert_id());
      }
      catch (Exception $e) {  }
      return (false);
   }
   
   public function save ($package)
   {
      if (!isset($package->packageId)) { return (false); }
      try
      {
         $data = $this->getData($package);
         if (count($data) > 0)
         {
            $this->db->where('ID', $package->packageId)
                     ->update('package', $data);
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
      $this->db->delete('package');
      return ($this->db->affected_rows() > 0);
   }
}

?>