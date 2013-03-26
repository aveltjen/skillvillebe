<?php namespace c\admin;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

abstract class User
{
   var $userId;
   var $schoolId;
   var $langId;
   var $userName;
   var $firstName;
   var $lastName;
   
   public function __construct($data)
   {
      $this->userId = $data['id'];
      $this->schoolId = $data['schoolid'];
      $this->langId = $data['langid'];
      $this->userName = $data['uname'];
      $this->firstName = $data['fname'];
      $this->lastName = $data['lname'];
   }
}

?>
