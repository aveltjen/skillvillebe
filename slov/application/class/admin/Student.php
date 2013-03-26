<?php namespace c\admin;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Student extends User
{
   var $birthDate;
   var $joinDate;
   var $groupId;
   
   public function __construct($data)
   {
      parent::__construct($data);
      $this->birthDate = $data['birthdate'];
      $this->joinDate = $data['joindate'];
      $this->groupId = $data['groupid'];
   }
}

?>
