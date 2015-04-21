jQuery("#toc").ready(function($) {
	$("a").click(function(){
		if ($(this).attr('href') [0] == '#') {
			var id = $(this).attr('href') + "";
			if(id.indexOf(".") != -1) {
				id = document.getElementById(id.replace("#",""));
			}
			$('html,body').animate({
				scrollTop: ($(id).offset().top - 60 )
			}, 400);
			return false;
		}
	});
});
