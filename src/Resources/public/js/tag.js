var Tag={
	selectedTag:
		function(tag,id)
		{
			textinput = $(id);
			value = textinput.value;
			expression = new RegExp('(,|^)('+tag+')\\s{0,}(,|$)','i');
			if (value.match(expression))
			{
				remove = new RegExp('(,|^)('+tag+')\\s{0,}(,|$)','i');
				replacement = (RegExp.$1==','&&RegExp.$3==',')?',':'';
				value = value.replace(remove,replacement);
				textinput.value=value
			}
			else
			{
				if (value.length==0)
				{
					value=tag
				}
				else
				{
					value=value.replace(/,{0,1}$/,','+tag)
				}
				textinput.value=value
			}
		}
	};