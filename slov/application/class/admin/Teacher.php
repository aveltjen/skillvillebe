<?php namespace c\admin;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Teacher extends User
{
   public function __construct($data)
   {
      parent::__construct($data);
   }
}

?>
