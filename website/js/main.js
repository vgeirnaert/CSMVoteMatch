window.onload=function(){  
	//randomBackground();
}  

function randomBackground() {
	var theBody = document.getElementById("body");  
	var imgarray = new Array("img/backgrounds/1.jpg", "img/backgrounds/3.jpg", "img/backgrounds/4.jpg", "img/backgrounds/5.jpg","img/backgrounds/6.jpg","img/backgrounds/7.jpg","img/backgrounds/8.jpg","img/backgrounds/9.jpg","img/backgrounds/10.jpg");  
	var spot = Math.floor(Math.random()* imgarray.length);  
	theBody.style.backgroundImage = "url('"+imgarray[spot]+"')";  
}

// smooth scrolling and making sure anchors aren't hidden by our nav bar
$('a[href*=#]').click(function() {
	if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		var $target = $(this.hash);
		$target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

		if ($target.length) {
			var targetOffset = $target.offset().top - 50;
			$('html,body').animate({scrollTop: targetOffset}, 200);
			return false;
		}
	}
});

// google+ button
(function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
