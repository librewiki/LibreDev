jQuery("#toc").ready(function($) {
	$("a").click(function(){
		var speed = 500;  // 스크롤 속도
		var href= jQuery(this).attr("href");
		//event.preventDefault();
		//$('html,body').animate({
		//	scrollTop: 0
		//}, 500);
		//return false;
	});
});
