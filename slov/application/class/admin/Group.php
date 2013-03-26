<?php namespace c\admin;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Group
{
   var $groupId;
   var $schoolId;
   var $createDate;
   var $name;
   var $key;
   var $packageId;
   var $packageName;
   var $curCount;
   
   public function __construct($data)
   {
      $this->groupId = $data['id'];
      $this->schoolId = $data['schoolid'];
      $this->createDate = $data['createdate'];
      $this->name = $data['name'];
      $this->key = $data['key'];
      $this->packageId = $data['packageId'];
      $this->packageName = $data['packageName'];
      $this->curCount = $data['curcount'];
   }
}

?>
