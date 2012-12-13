window.onload=function(){  
	randomBackground();
}  

function randomBackground() {
	var theBody = document.getElementById("body");  
	var imgarray = new Array("img/backgrounds/1.jpg", "img/backgrounds/3.jpg", "img/backgrounds/4.jpg", "img/backgrounds/5.jpg","img/backgrounds/6.jpg","img/backgrounds/7.jpg","img/backgrounds/8.jpg","img/backgrounds/9.jpg","img/backgrounds/10.jpg");  
	var spot = Math.floor(Math.random()* imgarray.length);  
	theBody.style.backgroundImage = "url('"+imgarray[spot]+"')";  
}
 
