// -- Robert Rodgers

(function($)
{
	el = $(document.createElement('div')).hide();
	msg = $(document.createElement('div')).css('margin', '16px');
	el.css('position', 'absolute')
	  .css('top', '0px')
	  .css('left', '0px')
	  .css('width', '100%')
	  .css('height', '100%')
	  .css('background-color', '#0000ff')
	  .css('color', '#ffffff')
	  .css('font-family', 'monospace')
	  .click(function () { $(this).fadeOut(350, function () { msg.empty(); }); })
	  .html('<h1 style="margin: 16px;">BSOD - Ajax Error</h1><br/>')
	  .append(msg);
	$('body').append(el);
	$(document).ajaxError(function (event, jqxhr, settings, exception)
	{
	   alert(jqxhr.responseText);
		/*msg.html(settings.url + '<br/><br/>The server returned:')
		   .append($(document.createElement('div'))
		   	  .css('color', '#000000')
		   	  .css('margin', '32px')
		   	  .css('padding', '16px')
		      .css('border', '#000000 2px solid')
		      .css('background-color', '#ffffff')
		      .html(jqxhr.responseText));
		el.fadeIn(350);*/
	});
})(jQuery);
