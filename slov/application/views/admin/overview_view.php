<div class='well' style='float: left; padding: 10px; margin: 8px; min-width: 280px; width: auto;'>
	<h3><?php echo $strtab->get('str_schoolinfo'); ?></h3>
	<label style='font-weight: bold;'><?php echo $strtab->get('str_schoolname'); ?>:</label>
	<?php echo $school->name; ?></br></br>
	<label style='font-weight: bold;'><?php echo $strtab->get('str_address'); ?>:</label>
	<?php echo $school->address; ?></br></br>
	<label style='font-weight: bold;'><?php echo $strtab->get('str_postcode'); ?>:</label>
	<?php echo $school->postCode; ?></br></br>
	<label style='font-weight: bold;'><?php echo $strtab->get('str_city'); ?>:</label>
	<?php echo $school->city; ?></br></br>
   <div style="padding: 8px;" class="well">
      <a id="updateSchool" href="#/admin_overview" class="btn"><?php echo $strtab->get('str_modify'); ?></a>
   </div>
</div>

<div class='well' style='float: left; padding: 10px; margin: 8px; min-width: 280px; width: auto;'>
	<h3><?php echo $strtab->get('str_admininfo'); ?></h3>
	<label style='font-weight: bold;'><?php echo $strtab->get('str_lastname'); ?></label>
	<?php echo $user->lastName; ?></br></br>
	<label style='font-weight: bold;'><?php echo $strtab->get('str_firstname'); ?></label>
	<?php echo $user->firstName; ?><br/><br/>
	<div style="padding: 8px;" class="well">
      <a id="updateAdmin" href="#/admin_overview" class="btn"><?php echo $strtab->get('str_modify'); ?></a>
   </div>
</div>

<div class='well' style='float: left; padding: 10px; margin: 8px; display: block; min-width: 635px; height: 400px;'>
<h3><?php echo $strtab->get('str_subscribed'); ?></h3>
<table class='table table-striped'>
	<tr>
		<th><?php echo $strtab->get('str_packname'); ?></th>
		<th><?php echo $strtab->get('str_packcount'); ?></th>
	</tr>
	<?php
		foreach ($packages as $package)
		{
		   echo '<tr><td>' . $package->name . '</td><td>' .
			   $package->curCount . ' / ' . $package->maxCount . '</td></tr>';
		}
	?>
</table>
</div>

<div id="modifyAdminDialog" title="<?php echo $strtab->get('str_modadmin'); ?>" style="display: none;">
   <div><span><?php echo $strtab->get('str_uname'); ?>:</span> <input id="modifyAdminUserName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_firstname'); ?>:</span> <input id="modifyAdminFirstName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_lastname'); ?>:</span> <input id="modifyAdminLastName" type="text"></input></div>
</div>
<div id="modifySchoolDialog" title="<?php echo $strtab->get('str_modschool'); ?>" style="display: none;">
   <div><span><?php echo $strtab->get('str_schoolname'); ?>:</span> <input id="modifySchoolName" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_address'); ?>:</span> <input id="modifySchoolAddress" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_postcode'); ?>:</span> <input id="modifySchoolPostcode" type="text"></input></div>
   <div><span><?php echo $strtab->get('str_city'); ?>:</span> <input id="modifySchoolCity" type="text"></input></div>
</div>

<script type="text/javascript" src="<?php echo base_url('js/admin/overview-dashboard.js');?>"></script>
<script type="text/javascript">
   (function($)
   {
      // Load the overview dashboard script:
      new AdminOverviewDashboard('<?php echo base_url('index.php/admin');?>',
         <?php echo json_encode($user); ?>,
         <?php echo json_encode($school); ?>);

   })(jQuery);
</script>
