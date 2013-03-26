// -- Robert Rodgers

var AdminGroupDashboard = (function($)
{
   return function (baseUrl)
   {
      this.currentGroup = null;
      this.maxStudents = 0;
      this.limit = 25;
      this.filter = null;
      
      this.nameSummary = function (name, createDate)
      {
         return ('(' + getAcademicYear(createDate) + ') ' + name);
      }
      
      this.loadGroup = function ()
      {
         button = $(this);
         main = button.data('main');
         id = button.data('id');
         infoContent = $("#infoGroupContent");
         infoContent.fadeOut(350);
         
         // e.data contains the teacher ID to load:
         $.get(baseUrl + '/get_group/' + id,
            function (data)
            {
               // Show the button is active:
               $('#groupList li').removeClass('active');
               li = button.parent().addClass('active');
               
               // Quickly test if a refresh of the name is in order:
               groupName = main.nameSummary(data.group.name, data.group.createDate);
               if (button.text() != groupName)
               {
                  li.slideUp(350, function () { button.text(groupName); li.slideDown(350); });
               }
               
               // Save group data:
               main.currentGroup = { data: data, li: li };
               main.populateSelect(data.group.curCount);
               
               infoContent.queue(function (next)
               {
                  // Load the returned object in the page:
                  $('#groupName').text(data.group.name);
                  $('#groupKey').text(data.group.key);
                  $('#groupYear').text(getAcademicYear(data.group.createDate));
                  $('#groupPackage').text(data.group.packageName);
                  $('#groupStudents').text(data.group.curCount);
                  
                  infoContent.fadeIn(350);
                  next();
               });
            });
      };
      
      this.loadStudents = function (offset, limit)
      {
         main = this;
         table = $('#groupStudentList');
         table.fadeOut(350);
         $.get(baseUrl + '/get_students_by_group/' + id + '/' + offset + '/' + limit,
            function (data)
            {
               table.queue(function (next)
               {
                  students = data.students;
                  $('#studentOffsetCurrent').text(offset + ' / ' + main.currentGroup.data.group.curCount);

                  table.empty()
                     .append($(document.createElement('tr'))
                        .append($(document.createElement('th')).text(strtab.get('str_id')))
                        .append($(document.createElement('th')).text(strtab.get('str_name')))
                        .append($(document.createElement('th')).text(strtab.get('str_firstname')))
                        .append($(document.createElement('th')).text(strtab.get('str_joined'))));
                        
                  for (key in students)
                  {
                     student = students[key];
                     table.append(main.createStudentRow(student,
                        { id: data.group.groupId,
                          studentId: student.userId }));
                  }
                  
                  table.fadeIn(350);
                  next();
               });
            });
      };
      
      this.populateSelect = function (count)
      {
         students = $('#studentOffset');
         students.empty();
         for (i = 0; true; i++)
         {
            cur = i * this.limit + 1;
            next = (i + 1) * this.limit;
            if (next >= count) { next = count - 1; }
            if (cur > next) { break; }
            el = $(document.createElement('option')).val(i)
               .text(cur + ' - ' + next);
            if (i == 0) { el.attr('selected', '1'); }
            students.append(el);
         }
      };
      
      this.populateFilter = function ()
      {
         this.filter.empty()
            .append($(document.createElement('option'))
            .attr('selected', 1).val('*')
            .text(strtab.get('str_showall')));
            
         rangeStart = new Date();
         rangeEnd = new Date();
         $('#groupList li').each(function ()
         {
            date = new Date($(this).data('date'));
            if (date < rangeStart) { rangeStart = date; }
            if (date > rangeEnd) { rangeEnd = date; }
         });
         
         while (rangeStart <= rangeEnd)
         {
            year = getAcademicYearFromDate(rangeStart);
            this.filter.append($(document.createElement('option'))
               .val(year).text(year));
            rangeStart.setYear(rangeStart.getFullYear() + 1);
         }
         
         // Show all by default:
         this.filter.parent().children('li').slideDown(350);
      };
      
      this.selectPrev = function ()
      {
         students = $('#studentOffset');
         current = students.children('option:selected').val() - 1;
         if (current < 0) { current = 0; }
         students.val(current);
      };
      
      this.selectNext = function ()
      {
         students = $('#studentOffset');
         current = students.children('option:selected').val() + 1;
         if (current > this.maxStudents) { current = this.maxStudents; }
         students.val(current);
      };
      
      this.selectChanged = function ()
      {
         current = $('#studentOffset').children('option:selected').val();
         this.loadStudents(current * this.limit, this.limit);
      };
      
      this.createStudentRow = function (student, data)
      {
         return ($(document.createElement('tr'))
            .append($(document.createElement('td')).text(student.userId))
            .append($(document.createElement('td')).text(student.lastName))
            .append($(document.createElement('td')).text(student.firstName))
            .append($(document.createElement('td')).text(student.joinDate)));
      };
      
      this.loadFirstGroup = function ()
      {
         this.currentGroup = null;
         el = $('#groupList li a').first();
         if (el.length) { el.click(); }
         else { $("#infoGroupContent").fadeOut(350); }
      }
      
      this.addGroup = function ()
      {
         obj = this;
         $('#addGroupName').val('');
         $('#addGroupDate').val(new Date);
         var buttons = { };
         
         buttons[strtab.get('str_addgroup')] = function()
            {
               // Check valid date:
               date = $('#addGroupDate').val();
               if (isNaN((new Date(date)).getDate()))
               {
                  dash.showMessage(
                     strtab.get('str_ok'),
                     strtab.get('str_dateerror'),
                     sprintf(strtab.get('str_dateerror2'), date)
                  );
                  return;
               }
               dialog = $(this);
               group =
               {
                  name: $('#addGroupName').val(),
                  createDate: date,
                  packageId: $('#addGroupPackage option:selected').val()
               };
               $.post(baseUrl + '/add_group',
                  { really_do_this: 'Yes, I am actually serious.', group: group },
                  function (data)
                  {
                     dialog.dialog('close');
                     obj.insertButton([ data.id, data.name, data.createDate ]);
                     obj.populateFilter();
                  });
            };
            
         buttons[strtab.get('str_cancel')] = function() { $(this).dialog('close'); };
            
         $('#addGroupDialog').dialog({
            resizable: true,
            width: 450,
            modal: true,
            show: { effect: 'clip', duration: 350 },
            hide: { effect: 'clip', duration: 350 },
            buttons: buttons
         });
      };
      
      this.modifyGroup = function ()
      {
         if (!this.currentGroup) { return; }
         var obj = this;
         var current = this.currentGroup;
         var group = current.data.group;
         var buttons = { };
         
         // Load current teacher info from the object:
         $('#modifyGroupName').val(group.name);
         
         buttons[strtab.get('str_save')] = function()
            {
               dialog = $(this);
               
               // Save data back into object and send to the server:
               $.post(baseUrl + '/save_group',
                  { really_do_this: 'Yes, I am actually serious.',
                    group:
                    {
                       groupId: group.groupId,
                       name: $('#modifyGroupName').val(),
                    }
                  },
                  function ()
                  {
                     dialog.dialog('close');
                     current.li.children().first().click();
                  });
            };
            
         buttons[strtab.get('str_cancel')] = function() { $(this).dialog('close'); };
        
         $('#modifyGroupDialog').dialog({
            resizable: true,
            width: 450,
            modal: true,
            show: { effect: 'clip', duration: 350 },
            hide: { effect: 'clip', duration: 350 },
            buttons: buttons
         });
      };
      
      this.removeGroup = function ()
      {
         if (!this.currentGroup) { return; }
         var obj = this;
         var current = this.currentGroup;
         var group = current.data.group;
         
         if (group.curCount > 0)
         {
            // Contains students - so the group cannot be removed:
            dash.showMessage(strtab.get('str_ok'), strtab.get('str_delerr'),
               sprintf(strtab.get('str_delerrmsg'), this.nameSummary(group.name, group.createDate)));
            return;
         }
         
         dash.showMessage(
            strtab.get('str_delgroup') + ';' + strtab.get('str_cancel'),
            strtab.get('str_delgroupask'),
            sprintf(strtab.get('str_delgroupmsg'), this.nameSummary(group.name, group.createDate)),
            function (resp, close)
            {
               if (resp == strtab.get('str_delgroup'))
               {
                  $.post(baseUrl + '/remove_group',
                      { really_do_this: 'Yes, I am actually serious.', id: group.groupId },
                      function ()
                      {
                         close();
                         current.li.slideUp(350, function ()
                            {
                               current.li.remove();
                               obj.loadFirstGroup();
                            });
                      });
               }
               else { close(); }
            });
      };
      
      this.insertButton = function (group, list)
      {
         if (!list) { list = $('#groupList'); }
         name = this.nameSummary(group[1], group[2]);
         
         el = $(document.createElement('a'))
            .attr('href', '#/admin_manage_groups').text(name)
            .data('id', group[0])
            .data('main', this)
            .click(this.loadGroup);
         el = $(document.createElement('li'))
            .append(el)
            .data('date', group[2])
            .data('year', getAcademicYear(group[2]))
            .hide();
         added = false;
         
         // Insert into the list, sorted according to name:
         
         list.children('li').each(function ()
         {
            cur = $(this);
            if (name.localeCompare(cur.text()) > 0) { return (true); }
            cur.before(el); added = true;
            return (false);
         });
         if (!added) { list.append(el); }
         
         el.slideDown(350);
      };
      
      this.applyFilter = function (e)
      {
         filter = e.data.filter;
         selected = filter.children('option:selected').val();
         if (selected == '*')
         {
            // Show all elements:
            filter.parent().children('li').slideDown(350);
         }
         else
         {
            // Show only elements that match the filter:
            filter.parent().children('li').each(function ()
            {
               li = $(this);
               if (li.data('year') == selected) { li.slideDown(350); }
               else { li.slideUp(350); }
            });
         }
      };
      
      this.reloadGroupList = function ()
      {
         var list = $('#groupList');
         var obj = this;
         list.hide(350, function ()
            {
               $.get(baseUrl + '/get_group_dashboard',
                  function (dashData)
                  {
                     var groupList = dashData.groups;
                     
                     list.empty().append($(document.createElement('h3')).text(strtab.get('str_groups')));
                     obj.filter = $(document.createElement('select')).change(obj, obj.applyFilter);
                     list.append(obj.filter);
                     
                     for (key in groupList) { obj.insertButton(groupList[key], list); }
                     obj.populateFilter();
                     
                     obj.loadFirstGroup();
                     list.show(350);
                  });
            });
      };
      
      new (function (obj)
      {
         $('#reloadGroup').click(function () { obj.reloadGroupList(); });
         $('#addGroup').click(function () { obj.addGroup(); });
         $('#updateGroup').click(function () { obj.modifyGroup(); });
         $('#removeGroup').click(function () { obj.removeGroup(); });
         $('#studentOffsetPrev').click(function () { obj.selectPrev(); });
         $('#studentOffsetNext').click(function () { obj.selectNext(); });
         $('#studentOffset').change(function () { obj.selectChanged(); });
         obj.reloadGroupList();
         
      })(this);
      
      return (this);
   };

})(jQuery);