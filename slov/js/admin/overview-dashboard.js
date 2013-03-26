// -- Robert Rodgers

var AdminOverviewDashboard = (function($)
{
   return function (baseUrl, admin, school)
   {
      this.modifySchool = function ()
      {
         var obj = this;
         
         // Load current teacher info from the object:
         $('#modifySchoolName').val(school.name);
         $('#modifySchoolAddress').val(school.address);
         $('#modifySchoolPostcode').val(school.postCode);
         $('#modifySchoolCity').val(school.city);
         
         var buttons = { };
         
         buttons[strtab.get('str_save')] = function()
            {
               dialog = $(this);
               
               // Save data back into object and send to the server:
               $.post(baseUrl + '/save_school',
                  { really_do_this: 'Yes, I am actually serious.',
                    school:
                    {
                       schoolId: school.schoolId,
                       name: $('#modifySchoolName').val(),
                       address: $('#modifySchoolAddress').val(),
                       postCode: $('#modifySchoolPostcode').val(),
                       city: $('#modifySchoolCity').val()
                    }
                  },
                  function ()
                  {
                     dialog.dialog('close');
                     //dash.refreshTab();
                     location.reload(); // Ugh...
                  });
            };
         
         buttons[strtab.get('str_cancel')] = function() { $(this).dialog('close'); };
         
         $('#modifySchoolDialog').dialog({
            resizable: true,
            width: 450,
            modal: true,
            show: { effect: 'clip', duration: 350 },
            hide: { effect: 'clip', duration: 350 },
            buttons: buttons
         });
      };
      
      this.modifyAdmin = function ()
      {
         var obj = this;
         
         // Load current teacher info from the object:
         $('#modifyAdminUserName').val(admin.userName);
         $('#modifyAdminFirstName').val(admin.firstName);
         $('#modifyAdminLastName').val(admin.lastName);
         
         var buttons = { };
         
         buttons[strtab.get('str_changepass')] = function()
            {
               dash.showChangePassword(function (good, password, close)
               {
                  if (good)
                  {
                     $.post(baseUrl + '/change_password',
                        { really_do_this: 'Yes, I am actually serious.',
                          password: password }, close);
                  }
               });
            };
         
         buttons[strtab.get('str_save')] = function()
            {
               dialog = $(this);
               
               // Save data back into object and send to the server:
               $.post(baseUrl + '/save_admin',
                  { really_do_this: 'Yes, I am actually serious.',
                    admin:
                    {
                       userId: admin.userId,
                       userName: $('#modifyAdminUserName').val(),
                       firstName: $('#modifyAdminFirstName').val(),
                       lastName: $('#modifyAdminLastName').val()
                    }
                  },
                  function ()
                  {
                     dialog.dialog('close');
                     location.reload();
                  });
            };
         
         buttons[strtab.get('str_cancel')] = function() { $(this).dialog('close'); };
         
         $('#modifyAdminDialog').dialog({
            resizable: true,
            width: 450,
            modal: true,
            show: { effect: 'clip', duration: 350 },
            hide: { effect: 'clip', duration: 350 },
            buttons: buttons
         });
      };
      
      obj = this;
      $('#updateSchool').click(function () { obj.modifySchool(); });
      $('#updateAdmin').click(function () { obj.modifyAdmin(); });
      
      return (this);
   };

})(jQuery);
