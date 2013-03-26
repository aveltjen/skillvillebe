// -- Robert Rodgers

var AdminTeacherDashboard = (function($)
{
   return function (baseUrl)
   {
      this.groupList = null;
      this.currentTeacher = null;
      
      this.nameSummary = function (name, firstName)
      {
         return (name + ', ' + firstName);
      }
      
      this.loadTeacher = function ()
      {
         button = $(this);
         main = button.data('main');
         id = button.data('id');
         infoContent = $("#infoTeacherContent");
         infoContent.fadeOut(350);
         
         // e.data contains the teacher ID to load:
         $.get(baseUrl + '/get_teacher/' + id,
            function (data)
            {
               // Show the button is active:
               $('#teacherList li').removeClass('active');
               li = button.parent().addClass('active');
               
               // Quickly test if a refresh of the name is in order:
               teacherName = main.nameSummary(data.teacher.lastName, data.teacher.firstName);
               if (button.text() != teacherName)
               {
                  li.slideUp(350, function () { button.text(teacherName); li.slideDown(350); });
               }
               
               // Save teacher data:
               main.currentTeacher = { data: data, li: li };
               
               infoContent.queue(function (next)
               {
                  // Load the returned object in the page:
                  $('#userName').text(data.teacher.userName);
                  $('#firstName').text(data.teacher.firstName);
                  $('#lastName').text(data.teacher.lastName);
                  
                  var otherGroups = [];
                  
                  tableAdded = $('#teacherGroups');
                  tableRemoved = $('#otherGroups');
                  main.createGroupSwitchHeader(tableAdded);
                  main.createGroupSwitchHeader(tableRemoved);
                  
                  // Load the group table:
                  for (key in main.groupList)
                  {
                     group = main.groupList[key];
                     if ($.inArray(group.groupId, data.groups) >= 0)
                     {
                        // If this was found in the teacher's set, display it here:
                        tableAdded.append(main.createGroupSwitchRow(group,
                           { id: data.teacher.userId,
                             groupId: group.groupId,
                             table: tableRemoved,
                             table2: tableAdded,
                             func: '/detach_teacher_group/',
                             func2: '/attach_teacher_group/' }));
                     }
                     else
                     {
                        // Otherwise, add it to the unassigned group bucket:
                        otherGroups.push(group);
                     }
                  }
                  
                  // Load the unassigned group table:
                  for (key in otherGroups)
                  {
                     group = otherGroups[key];
                     
                     tableRemoved.append(main.createGroupSwitchRow(group,
                        { id: data.teacher.userId,
                          groupId: group.groupId,
                          table: tableAdded,
                          table2: tableRemoved,
                          func: '/attach_teacher_group/',
                          func2: '/detach_teacher_group/' }));
                  }
                  
                  infoContent.fadeIn(350);
                  next();
               });
            });
      };
      
      this.createGroupSwitchHeader = function (table)
      {
         table.empty()
            .append($(document.createElement('tr'))
               .append($(document.createElement('th')).text(strtab.get('str_name')))
               .append($(document.createElement('th')).text(strtab.get('str_year')))
               .append($(document.createElement('th')).text(strtab.get('str_key')))
               .append($(document.createElement('th')).text(strtab.get('str_package'))));
      }
      
      this.createGroupSwitchRow = function (group, data)
      {
         return ($(document.createElement('tr'))
            .append($(document.createElement('td')).text(group.name))
            .append($(document.createElement('td')).text(getAcademicYear(group.createDate)))
            .append($(document.createElement('td')).text(group.key))
            .append($(document.createElement('td')).text(group.packageName))
            .click(data, this.groupSwitchFunction));
      };
      
      this.groupSwitchFunction = function (e)
      {
         // Submit the request to attach and reload the teacher:
         row = $(this); data = e.data;
         $.post(baseUrl + data.func + data.groupId + '/' + data.id,
            { really_do_this: 'Yes, I am actually serious.' },
            function ()
            {
               // To some toggling:
               row.detach();
               t = data.func; data.func = data.func2; data.func2 = t;
               t = data.table; data.table = data.table2; data.table2 = t;
               t.append(row);
            });
      };
      
      this.loadFirstTeacher = function ()
      {
         this.currentTeacher = null;
         el = $('#teacherList li a').first();
         if (el.length) { el.click(); }
         else { $("#infoTeacherContent").fadeOut(350); }
      }
      
      this.addTeacher = function ()
      {
         obj = this;
         $('#addTeacherUserName').val('');
         $('#addTeacherFirstName').val('');
         $('#addTeacherLastName').val('');
         
         var buttons = { };
         
         buttons[strtab.get('str_addteacher')] = function()
            {
               dialog = $(this);
               password = dash.validatePassword($('#addTeacherPassword'), $('#addTeacherConfirm'));
               if (password)
               {
                  teacher =
                  {
                     userName: $('#addTeacherUserName').val(),
                     password: password,
                     firstName: $('#addTeacherFirstName').val(),
                     lastName: $('#addTeacherLastName').val()
                  };
                  password = null;
                  
                  $.post(baseUrl + '/add_teacher',
                     { really_do_this: 'Yes, I am actually serious.', teacher: teacher },
                     function (data)
                     {
                        dialog.dialog('close');
                        obj.insertButton([ data.id, data.firstName, data.lastName ]);
                     });
                     
                  teacher.password = null;
               }
            };

         buttons[strtab.get('str_cancel')] = function() { $(this).dialog('close'); };
         
         $('#addTeacherDialog').dialog({
            resizable: true,
            width: 450,
            modal: true,
            show: { effect: 'clip', duration: 350 },
            hide: { effect: 'clip', duration: 350 },
            buttons: buttons
         });
      };
      
      this.modifyTeacher = function ()
      {
         if (!this.currentTeacher) { return; }
         var obj = this;
         var current = this.currentTeacher;
         var teacher = current.data.teacher;
         
         // Load current teacher info from the object:
         $('#modifyTeacherUserName').val(teacher.userName);
         $('#modifyTeacherFirstName').val(teacher.firstName);
         $('#modifyTeacherLastName').val(teacher.lastName);
         
         var buttons = { };
         
         buttons[strtab.get('str_changepass')] = function()
            {
               dash.showChangePassword(function (good, password, close)
               {
                  if (good)
                  {
                     $.post(baseUrl + '/change_password',
                        { really_do_this: 'Yes, I am actually serious.',
                          id: teacher.userId,
                          password: password }, close);
                  }
               });
            };
         
         buttons[strtab.get('str_save')] = function()
            {
               dialog = $(this);
               
               // Save data back into object and send to the server:
               $.post(baseUrl + '/save_teacher',
                  { really_do_this: 'Yes, I am actually serious.',
                    teacher:
                    {
                       userId: teacher.userId,
                       userName: $('#modifyTeacherUserName').val(),
                       firstName: $('#modifyTeacherFirstName').val(),
                       lastName: $('#modifyTeacherLastName').val()
                    }
                  },
                  function ()
                  {
                     dialog.dialog('close');
                     current.li.children().first().click();
                  });
            };
         
         buttons[strtab.get('str_cancel')] = function() { $(this).dialog('close'); };
         
         $('#modifyTeacherDialog').dialog({
            resizable: true,
            width: 450,
            modal: true,
            show: { effect: 'clip', duration: 350 },
            hide: { effect: 'clip', duration: 350 },
            buttons: buttons
         });
      };
      
      this.removeTeacher = function ()
      {
         if (!this.currentTeacher) { return; }
         var obj = this;
         var current = this.currentTeacher;
         var teacher = current.data.teacher;
         dash.showMessage(
            strtab.get('str_delteacher') + ';' + strtab.get('str_cancel'),
            strtab.get('str_delteacherask'),
            sprintf(strtab.get('str_delteachermsg'), this.nameSummary(teacher.lastName, teacher.firstName)),
            function (resp, close)
            {
               if (resp == strtab.get('str_delteacher'))
               {
                  $.post(baseUrl + '/remove_teacher',
                      { really_do_this: 'Yes, I am actually serious.', id: teacher.userId },
                      function ()
                      {
                         close();
                         current.li.slideUp(350, function ()
                            {
                               current.li.remove();
                               obj.loadFirstTeacher();
                            });
                      });
               }
               else { close(); }
            });
      };
      
      this.insertButton = function (teacher, list)
      {
         if (!list) { list = $('#teacherList'); }
         name = this.nameSummary(teacher[2], teacher[1]);
         
         el = $(document.createElement('a'))
            .attr('href', '#/admin_manage_teachers').text(name)
            .data('id', teacher[0])
            .data('main', this)
            .click(this.loadTeacher);
         el = $(document.createElement('li')).append(el).hide();
         added = false;
         
         // Insert into the list, sorted according to name:
         
         list.children('li').each(function (idx)
         {
            cur = $(this);
            if (name.localeCompare(cur.text()) > 0) { return (true); }
            cur.before(el); added = true;
            return (false);
         });
         if (!added) { list.append(el); }
         
         el.slideDown(350);
      };
      
      this.reloadTeacherList = function ()
      {
         var list = $('#teacherList');
         var obj = this;
         list.hide(350, function ()
            {
               $.get(baseUrl + '/get_teacher_dashboard',
                  function (dashData)
                  {
                     obj.groupList = dashData.groups;
                     var teacherList = dashData.teachers;
                     
                     list.empty().append($(document.createElement('h3')).text(strtab.get('str_teachers')));
                     for (key in teacherList) { obj.insertButton(teacherList[key], list); }
                     
                     obj.loadFirstTeacher();
                     list.show(350);
                  });
            });
      };
      
      new (function (obj)
      {
         $('#reloadTeacher').click(function () { obj.reloadTeacherList(); });
         $('#addTeacher').click(function () { obj.addTeacher(); });
         $('#updateTeacher').click(function () { obj.modifyTeacher(); });
         $('#removeTeacher').click(function () { obj.removeTeacher(); });
         obj.reloadTeacherList();
         
      })(this);
      
      return (this);
   };

})(jQuery);