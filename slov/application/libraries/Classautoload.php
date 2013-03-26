<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -- Robert Rodgers

class ClassAutoLoad
{
	public function __construct()
	{
		spl_autoload_register(array($this, 'loader'));
	}
	
	public function loader($className)
	{
		if (substr($className, 0, 2) != 'c\\') { return; }
		require APPPATH . 'class' . str_replace('\\', DIRECTORY_SEPARATOR, substr($className, 1)) . '.php';
	}
}

?>
