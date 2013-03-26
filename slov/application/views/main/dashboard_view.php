<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   	 <link href="<?php echo base_url('css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
       <link href="<?php echo base_url('css/jquery-ui.css');?>" rel="stylesheet" type="text/css" />
       <style type="text/css">
          #languagePicker { float: right; margin: 0px; margin-top: 5px; margin-right: 10px; }
       </style>
   </head>
   <body>
	
   	<div class="container">
   		<div class="navbar">
   			<div class="navbar-inner">
   				<a class="brand "  id="u" href="#"><?php echo $user->firstName; ?></a>
   				<ul class="nav" id="maintitle"> </ul>
   				<a class="btn" style="float: right;" href="<?php echo base_url('index.php/main/logout'); ?>"><i class="icon-off"></i> <?php echo $strtab->get('str_logout'); ?></a>
               <?php echo $strtab->getPickerHTML('languagePicker'); ?>
   			</div>
   		</div>
   	</div>
   	
   	<div id="dash_content"> </div>
   	
   	<div id="changePasswordDialog" title="<?php echo $strtab->get('str_changepass'); ?>" style="display: none;">
         <div><span><?php echo $strtab->get('str_newpass'); ?>:</span> <input id="changePasswordPassword" type="password"></input></div>
         <div><span><?php echo $strtab->get('str_confirmpass'); ?>:</span> <input id="changePasswordConfirm" type="password"></input></div>
      </div>
      <div id="messageDialog" style="display: none;">
         <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><span id="messageText"></span></p>
      </div>

      
   	<script type="text/javascript" src="<?php echo base_url('js/lib/jquery-1.9.0.js');?>"></script>
      <script type="text/javascript" src="<?php echo base_url('js/lib/jquery-ui.js');?>"></script>
      <script type="text/javascript" src="<?php echo base_url('js/lib/director.min.js');?>"></script>
      <script type="text/javascript" src="<?php echo base_url('js/helper/helper.js');?>"></script>
      <script type="text/javascript" src="<?php echo base_url('js/helper/translate.js');?>"></script>
   	<script type="text/javascript" src="<?php echo base_url('js/dashboard.js');?>"></script>
   	
      <script type="text/javascript">
         // This MUST be done before other content is loaded:
         var strtab = new StringTable('<?php echo base_url('index.php');?>', '#languagePicker');
         strtab.loadStatic(<?php echo $strtab->getJSON(); ?>);
   
<?php if (is_a($user, 'c\admin\Admin')) { ?>
         var dash = new Dashboard(strtab, '#maintitle', '#dash_content', '<?php echo base_url('index.php/dashboard');?>',
         {
            '/admin_overview' : '<?php echo $strtab->get('str_overview'); ?>',
            '/admin_manage_teachers' : '<?php echo $strtab->get('str_manteachers'); ?>',
            '/admin_manage_groups' : '<?php echo $strtab->get('str_mangroups'); ?>',
         });
         
<?php } else if (is_a($user, 'c\admin\Student')) { ?>
         var dash = new Dashboard(strtab, '#maintitle', '#dash_content', '<?php echo base_url('index.php/dashboard');?>',
         {
            '/student_overview' : '<?php echo $strtab->get('str_overview'); ?>',
         });
         
<?php } else if (is_a($user, 'c\admin\Teacher')) { ?>
         var dash = new Dashboard(strtab, '#maintitle', '#dash_content', '<?php echo base_url('index.php/dashboard');?>',
         {
            '/teacher_overview' : '<?php echo $strtab->get('str_overview'); ?>',
         });
         
<?php } ?>
      </script>
      
      <script type="text/javascript" src="<?php echo base_url('js/debug.js');?>"></script>
   </body>
</html>
