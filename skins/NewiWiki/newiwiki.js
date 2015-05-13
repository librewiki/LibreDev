var Base64 = {
 
            // private property
_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
 
          // public method for encoding
          encode : function (input) {
              var output = "";
              var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
              var i = 0;
 
              input = Base64._utf8_encode(input);
 
              while (i < input.length) {
 
                  chr1 = input.charCodeAt(i++);
                  chr2 = input.charCodeAt(i++);
                  chr3 = input.charCodeAt(i++);
 
                  enc1 = chr1 >> 2;
                  enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                  enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                  enc4 = chr3 & 63;
 
                  if (isNaN(chr2)) {
                      enc3 = enc4 = 64;
                  } else if (isNaN(chr3)) {
                      enc4 = 64;
                  }
 
                  output = output +
                      this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                      this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
 
              }
 
              return output;
          },
 
          // public method for decoding
decode : function (input) {
             var output = "";
             var chr1, chr2, chr3;
             var enc1, enc2, enc3, enc4;
             var i = 0;
 
             input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
 
             while (i < input.length) {
 
                 enc1 = this._keyStr.indexOf(input.charAt(i++));
                 enc2 = this._keyStr.indexOf(input.charAt(i++));
                 enc3 = this._keyStr.indexOf(input.charAt(i++));
                 enc4 = this._keyStr.indexOf(input.charAt(i++));
 
                 chr1 = (enc1 << 2) | (enc2 >> 4);
                 chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                 chr3 = ((enc3 & 3) << 6) | enc4;
 
                 output = output + String.fromCharCode(chr1);
 
                 if (enc3 != 64) {
                     output = output + String.fromCharCode(chr2);
                 }
                 if (enc4 != 64) {
                     output = output + String.fromCharCode(chr3);
                 }
 
             }
 
             output = Base64._utf8_decode(output);
 
             return output;
 
         },
 
         // private method for UTF-8 encoding
_utf8_encode : function (string) {
                   string = string.replace(/\r\n/g,"\n");
                   var utftext = "";
 
                   for (var n = 0; n < string.length; n++) {
 
                       var c = string.charCodeAt(n);
 
                       if (c < 128) {
                           utftext += String.fromCharCode(c);
                       }
                       else if((c > 127) && (c < 2048)) {
                           utftext += String.fromCharCode((c >> 6) | 192);
                           utftext += String.fromCharCode((c & 63) | 128);
                       }
                       else {
                           utftext += String.fromCharCode((c >> 12) | 224);
                           utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                           utftext += String.fromCharCode((c & 63) | 128);
                       }
 
                   }
 
                   return utftext;
               },
 
               // private method for UTF-8 decoding
_utf8_decode : function (utftext) {
                   var string = "";
                   var i = 0;
                   var c = c1 = c2 = 0;
 
                   while ( i < utftext.length ) {
 
                       c = utftext.charCodeAt(i);
 
                       if (c < 128) {
                           string += String.fromCharCode(c);
                           i++;
                       }
                       else if((c > 191) && (c < 224)) {
                           c2 = utftext.charCodeAt(i+1);
                           string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                           i += 2;
                       }
                       else {
                           c2 = utftext.charCodeAt(i+1);
                           c3 = utftext.charCodeAt(i+2);
                           string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                           i += 3;
                       }
 
                   }
 
                   return string;
               },
 
URLEncode : function (string) {
                return escape(this._utf8_encode(string));
            },
 
            // public method for url decoding
URLDecode : function (string) {
                return this._utf8_decode(unescape(string));
            }
        };


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
				html += "<li><a href = '/wiki/" + Base64.encode( item.title)  + "' title='" + item.title +"'>";
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
