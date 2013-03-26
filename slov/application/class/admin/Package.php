<?php namespace c\admin;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Package
{
   var $packageId;
   var $name;
   var $curCount;
   var $maxCount;
   
   public function __construct($data)
   {
      $this->packageId = $data['id'];
      $this->name = $data['name'];
      $this->curCount = $data['curcount'];
      $this->maxCount = $data['maxcount'];
   }
}

?>
