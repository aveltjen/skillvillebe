// -- Robert Rodgers

var Dashboard = (function($)
{
   return function (strtab, navId, contentId, baseUrl, menuItems)
   {
      navId = $(navId);
      contentId = $(contentId);
      
      this.currentLink = null;
      this.containers = { };
      this.router = null;
      this.routed = [];

      // Load content given by the link.
      this.loadContent = function (link)
      {
         dash = this;
         
         if (dash.currentLink == link) { return; }
         dash.currentLink = link;
         contentId.fadeOut(350);
         
         if (link in dash.containers)
         {
            // Already has a div for this link:
            current = dash.containers[link];
         }
         else
         {
            // Create a new div for the link:
            current =
            {
               hasData: false,
               div: $(document.createElement('div')).appendTo(contentId)
            };
            dash.containers[link] = current;
         }
         
         if (current.hasData == true)
         {
            // Show the already loaded data:
            contentId.queue(function (next)
            {
               contentId.children().hide();
               current.div.show();
               contentId.fadeIn(350);
               next();
            });
         }
         else
         {
            // Get data from server and load it in the element:
            $.get(baseUrl + link, function (data)
            {
               contentId.queue(function (next)
               {
                  contentId.children().hide();
                  current.div.html(data).show();
                  current.hasData = true;
                  contentId.fadeIn(350);
                  next();
               });
            });
         }
      };
      
      // Reload the data for the current tab:
      this.refreshTab = function ()
      {
         link = this.currentLink;
         this.currentLink = null;
         if (link in dash.containers)
         {
            // Force reload:
            dash.containers[link].hasData = false;
         }
         this.loadContent(link);
      };
      
      // Test if a key is already marked as routed.
      // Or set the key as routed if a value is supplied
      this.isRouted = function (key, value)
      {
         i = $.inArray(key, this.routed);
         if (value) { if (i < 0) { this.routed.push(key); } return; }
         return (i >= 0);
      };
      
      // Add a route to the router table.
      this.addRoute = function (link, func) { this.router.on(link, func); };
      
      this.showMessage = function (type, title, message, closeFunc)
      {
         dialog = $('#messageDialog');
         buttons = { };
         type = type.split(';');
         for (key in type)
         {
            name = type[key];
            buttons[name] = new (function (name)
            {
               return function ()
               {
                  if (closeFunc) { closeFunc(name, function () { dialog.dialog('close'); }); }
                  else { dialog.dialog('close'); }
               };
            })(name);
         }
         $('#messageText').text(message);
         dialog.dialog({
            resizable: false,
            width: 450,
            modal: true,
            show: { effect: 'clip', duration: 350 },
            hide: { effect: 'clip', duration: 350 },
            buttons: buttons
         });
         dialog.dialog('option', 'title', title);
      };
      
      this.validatePassword = function (passwordBox, confirmBox)
      {
         var password = passwordBox.val(); passwordBox.val('');
         var confirm = confirmBox.val(); confirmBox.val('');
         if (password != '')
         {
            if (password == confirm) { confirm = null; return (password); }
            else
            {
               this.showMessage(strtab.get('str_ok'),
                                strtab.get('str_passerr2'),
                                strtab.get('str_passerrmsg2'));
            }
         }
         else
         {
            this.showMessage(strtab.get('str_ok'),
                             strtab.get('str_passerr'),
                             strtab.get('str_passerrmsg'));
         }
         password = null; confirm = null;
         return (false);
      };
      
      this.showChangePassword = function (changeFunc)
      {
         dash = this;
         var buttons = { };
         
         buttons[strtab.get('str_save')] = function()
            {
               dialog = $(this);
               password = dash.validatePassword($('#changePasswordPassword'),
                                                $('#changePasswordConfirm'));
               if (password)
               {
                  changeFunc(true, password, function () { dialog.dialog('close'); });
                  password = null;
               }
            };
         
         buttons[strtab.get('str_cancel')] = function()
            {
               changeFunc(false);
               $(this).dialog('close');
            };
         
         $('#changePasswordDialog').dialog({
               resizable: true,
               width: 450,
               modal: true,
               show: { effect: 'clip', duration: 350 },
               hide: { effect: 'clip', duration: 350 },
               buttons: buttons
            });
      };
      
      // Initialization stuff...
      
      dashButton = function (parent, link, li)
      {
         return function (route)
         {
            li.parent().children().removeClass('active');
            li.addClass('active');
            parent.loadContent(link);
         };
      };

      first = undefined;
      routes = { };
      
      for (key in menuItems)
      {
         li = $(document.createElement('li'));
         a = $(document.createElement('a'))
            .attr('href', './#' + key)
            .html(menuItems[key]);

         buttonFunc = new dashButton(this, key, li);
         routes[key] = buttonFunc;
         
         navId.append(li.append(a));
         if (!first) { first = key; }
      }
      
      this.router = new Router(routes);
      this.router.init(first);
   };

})(jQuery);
