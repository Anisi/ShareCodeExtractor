var timer;
timer = 0;
function sync()
{
	$.getJSON( "ajax.updatedata.php", function( data ) {
		if (data.error == false)
		{
                    console.log(data);
			timer = 0;
			$.each( data, function( key, val ) {
				var problem_id = key;
				$.each( val, function( key, val ) {
					var time = Math.round((val.time - starttime)/60);
					$("tr[data-username='" + key + "']").find("td[data-problem='" + problem_id + "'] .try").text(val.try);
					$("tr[data-username='" + key + "']").find("td[data-problem='" + problem_id + "'] .time").text(time);
					if(val.result == false)
					{
						$("tr[data-username='" + key + "']").find("td[data-problem='" + problem_id + "']").addClass("danger");
					}
					else
					{
						$("tr[data-username='" + key + "']").find("td[data-problem='" + problem_id + "']").addClass("success");
					}
				});
			});
		}
		else
		{
			console.log('error');
		}
	});
}
setInterval(sync, 60000);

setInterval(function(){
	timer++;
    $('#timer').text(timer);
}, 1000);