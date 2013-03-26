<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

function getCurrentUser($obj)
{
   $user = $obj->session->userdata('user');
   if (!$user) { return (null); }
   return (unserialize($user));
}

function getStringTable($obj)
{
   $langId = $obj->session->userdata('lang');
   if (!$langId) { $langId = 'en'; }
   return (new c\StringTable($langId));
}

function getUserTypeCode($user)
{
   if (is_a($user, 'c\admin\Admin'  )) { return (0); }
   if (is_a($user, 'c\admin\Student')) { return (1); }
   if (is_a($user, 'c\admin\Teacher')) { return (2); }
   return (-1);
}

function arrayToObject($array)
{
   $obj = new stdClass;
   foreach ($array as $k => $v)
   {
      if(is_array($v)) { $obj->{$k} = array_to_object($v); }
      else { $obj->{$k} = $v; }
   }
   return ($obj);
} 

?>
