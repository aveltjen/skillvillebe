<?php namespace c\admin;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class School
{
   var $schoolId;
   var $name;
   var $address;
   var $postCode;
   var $city;
   
   public function __construct($data)
   {
      $this->schoolId = $data['id'];
      $this->name = $data['name'];
      $this->address= $data['address'];
      $this->postCode = $data['postcode'];
      $this->city = $data['city'];
   }
}

?>
