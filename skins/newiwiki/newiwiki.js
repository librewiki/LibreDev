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
		$(window).resize(function()
		{
			var width = $(window).width();
			if(width <= 750 || mobilecheck())
			{
				isAllowRequestList = false;
			}
			else
			{
				isAllowRequestList = true;
			}
		});
		if(isAllowRequestList == true)
		{
			setInterval(function(){
				ShowAjaxRecentList($("#recent-list"));
			},10 * 1000);
		}	
} );

var mobilecheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}
