<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

function toDate ($obj)
{
   if (is_numeric($obj)) { return (date('Y-m-d H:i:s', $obj)); }
   if (is_string($obj)) { return (date('Y-m-d H:i:s', strtotime($obj))); }
   return (date('Y-m-d H:i:s', $obj));
}

function getPasswordHash ($password)
{
   return (hash('sha256', $password));
}

?>
