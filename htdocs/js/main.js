var JSTemplate =
{
	render: function (template, data)
	{
		$.each(data, function(name, value)
		{
			template = template.replace('{' + name + '}', value);
		});
		return template;
	}
};

$(function() {
	$('form').submit(function() {
		var serialized_data = $(this).serializeArray();
		var action = $(this).attr('action');
		
		$.post(action, serialized_data, function(data) {
			console.log(data);
		});
		
		return false;
	});
});
