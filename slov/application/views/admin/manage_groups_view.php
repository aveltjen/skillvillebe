<div id="groupHead"></div>

<div style="margin: 20px; padding: 8px;" class="well">
   <a id="reloadGroup" href="#/admin_manage_groups" class="btn"><?php echo $strtab->get('str_reload'); ?></a>
   <a id="addGroup" href="#/admin_manage_groups" class="btn"><?php echo $strtab->get('str_addgroup'); ?></a>
   <a id="updateGroup" href="#/admin_manage_groups" class="btn"><?php echo $strtab->get('str_modgroup'); ?></a>
   <a id="removeGroup" href="#/admin_manage_groups" class="btn"><?php echo $strtab->get('str_delgroup'); ?></a>
</div>

<div class="tabbable tabs-left" style="margin-top: 20px;">
	<ul id="groupList" class="nav nav-tabs" style="padding: 20px; margin-right: 20px; display: none;">
	</ul>
	<div id="infoGroupContent" class="tab-content">
		<div class="well" style="float: left; padding: 10px; float: left;">
			<h4><?php echo $strtab->get('str_groupinfo'); ?></h4>
         <table>
            <tr><td><?php echo $strtab->get('str_name'); ?>: </td><td id="groupName"></td></tr>
            <tr><td><?php echo $strtab->get('str_key'); ?>: </td><td id="groupKey"></td></tr>
            <tr><td><?php echo $strtab->get('str_acyear'); ?>: </td><td id="groupYear"></td></tr>
            <tr><td><?php echo $strtab->get('str_package'); ?>: </td><td id="groupPackage"></td></tr>
            <tr><td><?php echo $strtab->get('str_totalstudents'); ?>: </td><td id="groupStudents"></td></tr>
         </table>
		</div>
		<div class="well" style="float: left; padding: 10px; float: left; margin-left: 20px;">
			<h4><?php echo $strtab->get('str_students'); ?></h4>
			<div style="text-align: center;">
   			<button id="studentOffsetPrev" class="btn">&lt;</button>
   			<select id="studentOffset"></select>
            <button id="studentOffsetNext" class="btn">&gt;</button><br/>
            <span id="studentOffsetCurrent">0 - 0</span>
         </div>
         <table id="groupStudentList" class="table table-striped">
		   </table>
		</div>
	</div>
</div>

<div id="modifyGroupDialog" title="<?php echo $strtab->get('str_modgroup'); ?>" style="display: none;">
   <div><span><?php echo $strtab->get('str_name'); ?>:</span> <input id="modifyGroupName" type="text"></input></div>
</div>
<div id="addGroupDialog" title="<?php echo $strtab->get('str_addgroup'); ?>" style="display: none;">
   <div><span><?php echo $strtab->get('str_name'); ?>:</span> <input id="addGroupName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_dateactive'); ?>:</span> <input id="addGroupDate" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_package'); ?>:</span> <select id="addGroupPackage">
      <?php
         $first = true;
         foreach ($packages as $package)
         {
            if ($first) { $first = false; echo '<option selected="1" value="'; }
            else { echo '<option value="'; }
            echo $package->packageId . '">' . $package->name . '</option>';
         }
      ?>
   </select></div>
</div>

<script type="text/javascript" src="<?php echo base_url('js/admin/group-dashboard.js');?>"></script>
<script type="text/javascript">
   (function($)
   {
      // Load the group dashboard script:
      new AdminGroupDashboard('<?php echo base_url('index.php/admin');?>');

   })(jQuery);
</script>
