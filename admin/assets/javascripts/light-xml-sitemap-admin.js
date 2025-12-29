(function($)
{
	'use strict';
	$(function()
	{
		if($('.input-status').length > 0)
		{
			$('.input-status').on('click',function()
			{
		    	if($(this).is(':checked'))
		    	{
		        	$("#handler-status").show(100)
		    	}
		    	else
		    	{
		    		$("#handler-status").hide(500)
		    	}
			});

			if($("#handler-status.show").length)
			{
			    $("#handler-status").show()
			}
		}
	});
})(jQuery);