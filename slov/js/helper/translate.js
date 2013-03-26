// -- Robert Rodgers

var StringTable = (function($)
{
   return function (baseUrl, languagePicker)
   {
      this.strtab = { };
      
      // Read a string from the table.
      this.get = function (id) { return (this.strtab[id]); }
      
      // Load a language:
      this.load = function (langId)
      {
         // Load the language pack synchronously:
         // If this returns, then the string table is loaded.
         $.ajax(
            {
               url: baseUrl + '/lang/strtab/' + langId,
               success: function (data) { this.strtab = data; },
               async: false
            });
      }
      
      this.loadStatic = function (data)
      {
         this.strtab = data;
      };
      
      // Attach to the language picker widget:
      if (languagePicker)
      {
         languagePicker = $(languagePicker);
         languagePicker.change(function ()
         {
            // Go change the language:
            $(document.createElement('form'))
               .hide()
               .attr('method', 'POST')
               .attr('action', baseUrl + '/main/lang/' + languagePicker.children('option:selected').val())
               .append($(document.createElement('input'))
                  .attr('name', 'nav')
                  .attr('value', window.location))
               .appendTo('body')
               .submit();
         });
      }
   };
})(jQuery);
