<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   	 <link href="<?php echo base_url('css/bootstrap.min.css');?>" rel="stylesheet" media="screen">
   	 <link href="<?php echo base_url('css/main.css');?>" rel="stylesheet" media="screen">
   	 <style type="text/css">
         #languagePicker { float: right; margin: 0px; margin-top: 5px; margin-right: 10px; }
   	 </style>
   </head>
   <body>
	<img src="<?php echo base_url('img/bg_skillville_front.jpg');?>" class="bg">
	<img src="<?php echo base_url('img/skillville_logo2.png');?>" class="logo">
   	<div id="login_header" style='width: 100%; padding: 5px 0px 10px 0px; float: left;'>
   	   <h1 style='float: left; margin-left: 20px; text-shadow: 1px 1px white;'></h1>
   	   <?php echo $strtab->getPickerHTML('languagePicker'); ?>
   	   </div>
   	<div id="login_content" style='float: right; width: 100%; height: auto;'>
   		<div id="login_form" style='float: right;'>
   			<h2> <?php echo $strtab->get('str_login'); ?> </h2>
   			<form action='<?php echo base_url('index.php/main/login'); ?>' method='post'>
   				<label> <?php echo $strtab->get('str_username'); ?> </label>
   				<input type='text' name='username' placeholder='<?php echo $strtab->get('str_uname'); ?>'/>
   				</br>
   				<label> <?php echo $strtab->get('str_password'); ?> </label>
   				<input type='password' name='password' placeholder='<?php echo $strtab->get('str_pass'); ?>'/>
   				</br>
   				<button class='btn btn-primary' href=''><i class='icon-user icon-white'></i> <?php echo $strtab->get('str_login'); ?> </button>
   				<a href='#' style='margin-left: 12px;'><?php echo $strtab->get('str_nopass'); ?></a>
   			</form>
   			<?php 
   			if ($prevLogin == true)
            {
      			if ($username == "" && $password == "")
      			{
      			   echo "<div class='alert alert-block'><h4>" .
      			      $strtab->get('str_ohno') . "</h4>" . $strtab->get('str_msg1') . "</div>";
               }
      			else if ($username == "")
      			{
      			   echo "<div class='alert alert-block'><h4>" .
                     $strtab->get('str_ohno') . "</h4>" . $strtab->get('str_msg2') . "</div>";
               }
      			else if ($password == "")
      			{
      			   echo "<div class='alert alert-block'><h4>" .
                     $strtab->get('str_ohno') . "</h4>" . $strtab->get('str_msg3') . "</div>";
               }
      			else
      			{
      			   echo "<div class='alert alert-error'><h4>" .
                     $strtab->get('str_ohno') . "</h4>" . $strtab->get('str_msg4') . "</div>";
               }
   			}
   			?>
   		</div>
   	</div>
      <script type="text/javascript" src="<?php echo base_url('js/lib/jquery-1.9.0.js');?>"></script>
      <script type="text/javascript" src="<?php echo base_url('js/helper/translate.js');?>"></script>
      <script type="text/javascript">
         new StringTable('<?php echo base_url('index.php');?>', '#languagePicker');
      </script>
   </body>
</html>
