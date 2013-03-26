<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class Lang extends CI_Controller
{
   // Load English language pack by default:
   public function index() { $this->strtab('en'); }
   
   // language and translation functions:
   
   public function strtab($langId, $set)
   {
      $strtab = new c\StringTable($langId);
      if (!$strtab->loadSet($set))
      {
         // Set not found:
         $this->output->set_status_header(404);
         return;
      }
      
      // Send the language pack
      $this->output->set_content_type('application/json');
      $this->output->set_output($strtab->getJSON());
   }
}

?>
