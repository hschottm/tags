var TagCloudRequest={
	toggleTagCloud:
		function(el,pageID)
		{
			el.blur();
			var display=(el.parent().next().css('display')=='none')?'block':'none';
			el.parent().next().css('display',display);
			(display=='none')?el.addClass('yes'):el.removeClass('yes');
			return false
		}
	};
	
	
$(document).ready(
	function()
	{
		$('span').each(
			function(index)
			{
				if ($(this).hasClass('toggle-button'))
				{
					$(this).removeClass('off');
				}
			}
		);
	}
);