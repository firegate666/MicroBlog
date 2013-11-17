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

var AjaxProcessor = {
	getJSON: function (data, callback)
	{
		$.ajax({
			dataType: 'json',
			data: data,
			success: callback
		});

	}
};

$(function() {
	$('form').submit(function() {
		var serialized_data = $(this).serializeArray();
		var action = $(this).attr('action');

		$.post(action, serialized_data, function(data) {
			console.log('form submit post', data);
		});

		return false;
	});

	$('.blogs').each(function ()
	{
		AjaxProcessor.getJSON({}, function (data)
		{
			var template = $('script[name="blog_item"]').html();
			var response = '';
			$.each(data, function(k, blog)
			{
				response += JSTemplate.render(template, blog);
			});
			$('ul.blogs').append(response);
		});
	});

});
