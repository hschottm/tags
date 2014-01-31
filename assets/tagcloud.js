(function($, undef) {
// jQuery
	if(!$) return;

	TagCloudRequest={
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
})(window.jQuery);

(function($, $$, undef) {
// Mootools
	if(!$) return;

	TagCloudRequest =
	{
		toggleTagCloud: function(el, pageID)
		{
			el.blur();
			display = (el.getParent().getNext().getStyle('display') == 'none') ? 'block' : 'none';
			el.getParent().getNext().setStyle('display', display); 
			(display == 'none') ? el.addClass('yes') : el.removeClass('yes');
			new Request({url: window.location.href, data: 'toggleTagCloud=1&cloudPageID=' + pageID + '&cloudID=' + el.id + '&display=' + display}).send();
			return false;
		}
	};

	window.addEvent('domready', function() {
	  $(document.body).getElements('span').each(function(item, index){ if (item.hasClass('toggle-button')) { item.removeClass('off');  } });
	});
})(document.id, window.$$);
