//윈도우 사이즈에 따라 변경을 할지 않할 지 체크한다.
var isAllowRequestList = true;
//매개 변수 parent는 ul태그여야 합니다
function ShowAjaxRecentList(parent)
{
	function temp()
	{
		var getParameter = 
		{
			action:"query",
			list:"recentchanges",
			rcprop:"title|timestamp",
			rclimit:10,
			format:"json"
		};
		$.ajax("/api.php",
		{
			data:getParameter,
			dataType:"json"
		}
			)
		.done(function(res)
		{
			var html = "";
			for(var i = 0 ; i < res.query.recentchanges.length ; i++)
			{
				var item = res.query.recentchanges[i];
				html += "<li><a href = '/wiki/" + item.title + "' title='" + item.title +"'>";
				var timestamp = item.timestamp;
				var timeStartIdx = timestamp.indexOf("T") + 1;
				var time = timestamp.substr(timeStartIdx,timestamp.length- timeStartIdx - 1);
				var hour =parseInt(time.substr(0,time.indexOf(":"))) ;
				hour += 9;
				hour = hour % 24;
				if(hour < 10)
				{
					hour = "0" + hour;
				}
				time = hour + time.substr(time.indexOf(":"),time.length - (time.indexOf(":") - 1));

				 html += "[" + time + "] ";
				 var text = "";
				if(item.type == "new")
				{
					text += "[New]";
				}
				text += item.title;
				if(text.length > 12)
				{
					text = text.substr(0,12);
					text +="...";
				}
				text =text.replace("[New]","<span class='new'>[New]</span>");
				html += text;
				html += "</a></li>"
			}
			if(parent != null)
			{
				$(parent).html(html);
			}
		});
	}
	temp();
}

/**
 * Vector-specific scripts
 */
var recentIntervalHandle = null;

jQuery( function ( $ ) {
	$( 'div.vectorMenu' ).each( function () {
		var $el = $( this );
		$el.find( '> h3 > a' ).parent()
			.attr( 'tabindex', '0' )
			// For accessibility, show the menu when the h3 is clicked (bug 24298/46486)
			.on( 'click keypress', function ( e ) {
				if ( e.type === 'click' || e.which === 13 ) {
					$el.toggleClass( 'menuForceShow' );
					e.preventDefault();
				}
			} )
			// When the heading has focus, also set a class that will change the arrow icon
			.focus( function () {
				$el.find( '> a' ).addClass( 'vectorMenuFocus' );
			} )
			.blur( function () {
				$el.find( '> a' ).removeClass( 'vectorMenuFocus' );
			} )
			.find( '> a:first' )
			// As the h3 can already be focused there's no need for the link to be focusable
			.attr( 'tabindex', '-1' );
	} );

	/**
	 * Collapsible tabs for Vector
	 */
	var $cactions = $( '#p-cactions' );

	// Bind callback functions to animate our drop down menu in and out
	// and then call the collapsibleTabs function on the menu
	$( '#p-views ul' )
		.bind( 'beforeTabCollapse', function () {
			// If the dropdown was hidden, show it
			if ( $cactions.hasClass( 'emptyPortlet' ) ) {
				$cactions
					.removeClass( 'emptyPortlet' )
					.find( 'h3' )
						.css( 'width', '1px' ).animate( { 'width': '24px' }, 390 );
			}
		} )
		.bind( 'beforeTabExpand', function () {
			// If we're removing the last child node right now, hide the dropdown
			if ( $cactions.find( 'li' ).length === 1 ) {
				$cactions.find( 'h3' ).animate( { 'width': '1px' }, 390, function () {
					$( this ).attr( 'style', '' )
						.parent().addClass( 'emptyPortlet' );
				});
			}
		} )
		.collapsibleTabs();
		
	var width = $(window).width();
	if(width > 750)
	{
		isAllowRequestList = true;
		ShowAjaxRecentList($("#recent-list"));
	}
	else
	{
		isAllowRequestList = false;
	}
		
	//만약에 화면의 사이즈가 작아 최근 변경글이 안보일 시, 갱신을 하지 않는다.
	$(window).resize(recentIntervalCheck);	
} );

var recentIntervalCheck = function(){
	var width = $(window).width();
	if(width <= 750){
		if(recentIntervalHandle != null){
			clearInterval(recentIntervalHandle);
			recentIntervalHandle = null;
		}
		isAllowRequestList = false;
	}else{
		if(recentIntervalHandle == null){
			recentIntervalHandle = setInterval(function(){
				ShowAjaxRecentList($("#recent-list"));
			},10 * 1000);
		}
		isAllowRequestList = true;
	}
}

jQuery(document).ready(function($){
	recentIntervalCheck();
});
