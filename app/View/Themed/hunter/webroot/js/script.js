/* Author: will@asecondsystem.com

*/
 $(document).ready(function() { 
        $('ul.sf-menu').superfish({ 
            delay:       1000,                            // one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast',                          // faster animation speed 
            autoArrows:  true,                           // disable generation of arrow mark-up 
            dropShadows: false                            // disable drop shadows 
        }); 
        
        $('#slider ul').cycle({
			fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		});
		
		
		
		
		/*
			Book mark this page. (browser bookmark)
			usage: <a href='http://example.com' class='jQueryBookmark'>weeeee!</a>
		*/
		
		if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) { 
            $('.jQueryBookmark').hide(); 
        } 
		

		$("a.jQueryBookmark").click(function(e){

			e.preventDefault(); // this will prevent the anchor tag from going the user off to the link
			var bookmarkUrl = this.href;
			var bookmarkTitle = this.title;

			
		 
			if (window.sidebar) { // For Mozilla Firefox Bookmark
				alert('Netscape, and FireFox users, use CTRL+D to bookmark this site.');
			} else if( window.external || document.all) { // For IE Favorite
				window.external.AddFavorite( bookmarkUrl, bookmarkTitle);
			} else if(window.opera) { // For Opera Browsers
				$("a.jQueryBookmark").attr("href",bookmarkUrl);
				$("a.jQueryBookmark").attr("title",bookmarkTitle);
				$("a.jQueryBookmark").attr("rel","sidebar");
			} else { // for other browsers which does not support
				 alert('Your browser does not support automatic bookmarking. Try dragging the link to the bookmarks bar.');
				 return false;
			}
			

		});

		
		$('#name').watermark('Your Name');
					$('#bjttit-bjttit').watermark('Your Email');
		
		
		
});    