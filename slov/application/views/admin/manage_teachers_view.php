<div id="teacherHead"></div>

<div style="margin: 20px; padding: 8px;" class="well">
   <a id="reloadTeacher" href="#/admin_manage_teachers" class="btn"><?php echo $strtab->get('str_reload'); ?></a>
   <a id="addTeacher" href="#/admin_manage_teachers" class="btn"><?php echo $strtab->get('str_addteacher'); ?></a>
   <a id="updateTeacher" href="#/admin_manage_teachers" class="btn"><?php echo $strtab->get('str_modteacher'); ?></a>
   <a id="removeTeacher" href="#/admin_manage_teachers" class="btn"><?php echo $strtab->get('str_delteacher'); ?></a>
</div>

<div class="tabbable tabs-left" style="margin-top: 20px;">
	<ul id="teacherList" class="nav nav-tabs" style="padding: 20px; margin-right: 20px; display: none;">
	</ul>
	<div id="infoTeacherContent" class="tab-content" style="display: none;">
	   <div class="well" style="float: left; padding: 10px; float: left;">
			<h4><?php echo $strtab->get('str_basicinfo'); ?></h4>
		   <table>
            <tr><td><?php echo $strtab->get('str_uname'); ?>:</td><td id="userName"></td></tr>
		      <tr><td><?php echo $strtab->get('str_firstname'); ?>:</td><td id="firstName"></td></tr>
            <tr><td><?php echo $strtab->get('str_lastname'); ?>:</td><td id="lastName"></td></tr>
		   </table>
		</div>
		<div style="clear: both;"> </div>
		<div class="well" style="float: left; padding: 10px; float: left; ">
			<h4><?php echo $strtab->get('str_assigned'); ?></h4>
			<table id="teacherGroups" class="table table-striped">
		   </table>
		</div>
		<div class="well" style="float: left; padding: 10px; float: left; margin-left: 8px;">
         <h4><?php echo $strtab->get('str_unassigned'); ?></h4>
         <table id="otherGroups" class="table table-striped">
         </table>
      </div>
	</div>
</div>

<div id="modifyTeacherDialog" title="<?php echo $strtab->get('str_modteacher'); ?>" style="display: none;">
   <div><span><?php echo $strtab->get('str_uname'); ?>:</span> <input id="modifyTeacherUserName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_firstname'); ?>:</span> <input id="modifyTeacherFirstName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_lastname'); ?>:</span> <input id="modifyTeacherLastName" type="text"></input></div>
</div>
<div id="addTeacherDialog" title="<?php echo $strtab->get('str_addteacher'); ?>" style="display: none;">
   <div><span><?php echo $strtab->get('str_uname'); ?>:</span> <input id="addTeacherUserName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_newpass'); ?>:</span> <input id="addTeacherPassword" type="password"></input></div>
   <div><span><?php echo $strtab->get('str_confirmpass'); ?>:</span> <input id="addTeacherConfirm" type="password"></input></div>
   <div><span><?php echo $strtab->get('str_firstname'); ?>:</span> <input id="addTeacherFirstName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_lastname'); ?>:</span> <input id="addTeacherLastName" type="text"></input></div>
</div>

<script type="text/javascript" src="<?php echo base_url('js/admin/teacher-dashboard.js');?>"></script>
<script type="text/javascript">
   (function($)
   {
      // Load the teacher dashboard script:
      new AdminTeacherDashboard('<?php echo base_url('index.php/admin');?>');

   })(jQuery);
</script>
