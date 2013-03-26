<?php namespace c;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class StringTable
{
   var $langId;
   var $path;
   var $strtab;
   
   public function __construct($langId)
   {
      $this->langId = $langId;
      // Sanitise the input for safety:
      $this->path = './lang/' . preg_replace('/[^a-z0-9-. ]+/i', '', $langId) . '/';
      $this->strtab = array();
   }
   
   public function loadSet($name)
   {
      // Load the language pack:
      $data = read_file($this->path . $name . '.xml');
      if ($data == false) { return (false); }
      
      // Parse the xml file into an array:
      $xml = xml_parser_create();
      xml_set_object($xml, $this);
      xml_set_element_handler($xml, 'xmlStart', false);
      xml_set_character_data_handler($xml, 'xmlData');
      xml_parse($xml, $data, true);
      xml_parser_free($xml);
      
      return (true);
   }
   
   public function get($id)
   {
      // Get the translated word by ID.
      return ($this->strtab[$id]);
   }
   
   public function getJSON()
   {
      // Get the string table as a JSON string:
      return (json_encode($this->strtab));
   }
   
   public function getPickerHTML($id)
   {
      // Generate the language picker HTML:
      $html = '<select id="' . $id . '">';
      require_once('./lang/lang.php');
      foreach ($languages as $key => $language)
      {
         if ($key != $this->langId) { $html .= '<option '; }
         else { $html .= '<option selected="1" '; }
         $html .= 'value="' . $key . '">' . $language . '</option>';
      }
      $html .= '</select>';
      return ($html);
   }
   
   // XML Parsing Functions
   var $key;
   function xmlStart($parser, $name, $attr) { $this->key = strtolower($name); }
   function xmlData($parser, $data)
   {
      $data = trim($data);
      if (!key_exists($this->key, $this->strtab)) { $this->strtab[$this->key] = $data; }
      else { $this->strtab[$this->key] .= $data; }
   }
}

?>
